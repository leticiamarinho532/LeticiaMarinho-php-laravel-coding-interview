docker info > /dev/null 2>&1

# Ensure that Docker is running...
if [ $? -ne 0 ]; then
    echo "Docker is not running."

    exit 1
fi

# Install composer packages
echo "Installing composer packages"
docker run --rm \
    --pull=always \
    -v "$(pwd)":/opt/web \
    -w /opt/web \
    --user "$(id -u):$(id -g)" \
    laravelsail/php82-composer:latest \
    bash -c "composer install"

echo "Building container images"
# Setting user and group id for containers
export WWWUSER=$(id -u)
export WWWGROUP=$(id -g)
./vendor/bin/sail build

echo "Starting containers"
./vendor/bin/sail up -d

echo "All set, you can start developing!"
