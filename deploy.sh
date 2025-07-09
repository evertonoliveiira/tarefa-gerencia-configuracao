#!/usr/bin/env bash
set -e

# ────────────────────────────────────────────────────────────────
# Identifica a branch atual e seleciona docker-compose + .env
# ────────────────────────────────────────────────────────────────
BRANCH=$(git rev-parse --abbrev-ref HEAD)
echo "Deploy na branch: $BRANCH"

case "$BRANCH" in
  homolog)
    COMPOSE_FILE="docker-compose.homolog.yml"
    ENV_FILE=".env.homolog"
    ;;
  main)
    COMPOSE_FILE="docker-compose.yml"
    ENV_FILE=".env.prod"
    ;;
  *)
    echo "Este script só roda nas branches homolog ou main."
    exit 1
    ;;
esac

# ────────────────────────────────────────────────────────────────
# Atualiza código
# ────────────────────────────────────────────────────────────────
echo "Atualizando código..."
git fetch origin "$BRANCH"
git reset --hard "origin/$BRANCH"

# ────────────────────────────────────────────────────────────────
# Reinicia containers
# ────────────────────────────────────────────────────────────────
echo "Limpando containers antigos (se existirem)…"
docker-compose -f "$COMPOSE_FILE" --env-file "$ENV_FILE" down -v || true

echo "Iniciando containers..."
sudo docker-compose -f "$COMPOSE_FILE" --env-file "$ENV_FILE" up -d --build

# ────────────────────────────────────────────────────────────────
# Container da aplicação
# ────────────────────────────────────────────────────────────────
CONTAINER_ID=$(sudo docker-compose -f "$COMPOSE_FILE" ps -q app)
echo "Container app: $CONTAINER_ID"

# ────────────────────────────────────────────────────────────────
# Aguarda PostgreSQL
# ────────────────────────────────────────────────────────────────
echo "Aguardando PostgreSQL ficar disponível..."
sudo docker exec "$CONTAINER_ID" bash -lc '
timeout=120
elapsed=0
while ! (echo > /dev/tcp/db/5432) 2>/dev/null; do
  if [ $elapsed -ge $timeout ]; then
    echo "Timeout ao conectar com PostgreSQL"; exit 1
  fi
  sleep 3; elapsed=$((elapsed+3))
  echo "  ➤ Esperando conexão com db:5432... ($elapsed s)"
done
echo "PostgreSQL disponível."
'

# ────────────────────────────────────────────────────────────────
# Passos dentro do container da aplicação
# ────────────────────────────────────────────────────────────────
echo "Ajustando permissões..."
sudo docker exec "$CONTAINER_ID" bash -lc \
  "chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
   chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"

echo "Instalando dependências PHP (se necessário)..."
sudo docker exec "$CONTAINER_ID" bash -lc \
  "if [ ! -d '/var/www/html/vendor' ]; then \
     composer install --no-interaction --prefer-dist --optimize-autoloader; \
   fi"

echo "Gerando assets (Vite) (se necessário)..."
sudo docker exec "$CONTAINER_ID" bash -lc \
  "if [ ! -f '/var/www/html/public/build/manifest.json' ]; then \
     npm install --prefix /var/www/html && npm run build --prefix /var/www/html; \
   fi"

echo "Sincronizando .env (via docker cp)…"
# copia direto do host para o container, evita arquivos residuais
docker cp "$ENV_FILE" "$CONTAINER_ID":/var/www/html/.env

echo "Gerando APP_KEY (se faltar) e limpando cache…"
sudo docker exec "$CONTAINER_ID" bash -lc "\
  php artisan key:generate --force && \
  php artisan config:clear && \
  echo '⬇️  Verificação rápida do .env:' && \
  grep -E '^(APP_ENV|APP_KEY|DB_HOST|DB_DATABASE)' /var/www/html/.env
"

echo "Executando migrations e cache…"
sudo docker exec "$CONTAINER_ID" bash -lc "\
  php artisan migrate --force && \
  php artisan config:cache && \
  php artisan route:cache
"