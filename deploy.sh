#!/usr/bin/env bash
set -e

# 1. Identifica a branch atual
BRANCH=$(git rev-parse --abbrev-ref HEAD)
echo "Deploy na branch: $BRANCH"

# 2. Define compose e env conforme branch
if [ "$BRANCH" = "homolog" ]; then
  COMPOSE_FILE="docker-compose.homolog.yml"
  ENV_FILE=".env.homolog"
elif [ "$BRANCH" = "main" ]; then
  COMPOSE_FILE="docker-compose.yml"
  ENV_FILE=".env.prod"
else
  echo "Este script só roda em homolog ou main."
  exit 1
fi

# 3. Atualiza código
echo "Atualizando código..."
git fetch origin $BRANCH
git reset --hard origin/$BRANCH

# 4. Build & up dos containers (com sudo, se precisar)
echo "Iniciando containers..."
sudo docker-compose -f $COMPOSE_FILE --env-file $ENV_FILE up -d --build

# 5. Captura ID do container ‘app’
CONTAINER_ID=$(sudo docker-compose -f $COMPOSE_FILE ps -q app)
echo "Container app: $CONTAINER_ID"

# 6. Ajusta permissões
echo "Ajustando permissões..."
sudo docker exec $CONTAINER_ID bash -lc "\
  chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
  chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"

# 7. Instala dependências PHP se faltar
echo "Instalando dependências PHP (se necessário)..."
sudo docker exec $CONTAINER_ID bash -lc "\
  if [ ! -d '/var/www/html/vendor' ]; then \
    composer install --no-interaction --prefer-dist --optimize-autoloader; \
  fi"

# 8. Gera assets Vite se faltar
echo "Gerando assets (Vite) (se necessário)..."
sudo docker exec $CONTAINER_ID bash -lc "\
  if [ ! -f '/var/www/html/public/build/manifest.json' ]; then \
    npm install --prefix /var/www/html && npm run build --prefix /var/www/html; \
  fi"

# 9. Aguarda o DB
echo "Aguardando PostgreSQL ficar disponível..."
sudo docker exec $CONTAINER_ID bash -lc "\
  timeout=60 elapsed=0; \
  until pg_isready -h \"\$DB_HOST\" -p \"\$DB_PORT\" > /dev/null 2>&1 || [ \$elapsed -ge \$timeout ]; do \
    sleep 3; elapsed=\$((elapsed+3)); echo \"  ➤ Esperando... (\$elapsed s)\"; \
  done; \
  [ \$elapsed -lt \$timeout ] || { echo 'Timeout no DB'; exit 1; }"

# 10. Roda migrations e gera cache/routes
echo "Executando migrations e cache..."
sudo docker exec $CONTAINER_ID bash -lc "\
  php artisan migrate --force && \
  php artisan config:cache && \
  php artisan route:cache"

echo "Deploy concluído para $BRANCH"