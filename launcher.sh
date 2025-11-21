#!/bin/bash

# Function to display loading spinner while the docker container is building
show_loading_spinner() {
    local pid=$!
    local spin='-\|/'
    local i=0
    echo -n 'Building container, please wait... '
    while kill -0 "$pid" 2>/dev/null; do
        printf "\b${spin:i++%${#spin}:1}"
        sleep .1
    done
    echo -e "\bDone!"
}

# Function to check if a Docker container is running on a specific port
check_port_conflict() {
    target_port=$1
    container_name=$(docker ps --filter "expose=$target_port" --format "{{.Names}}")
    if [ -n "$container_name" ]; then
        echo -e "\e[31mError: There is already a container running on port $target_port: $container_name\e[0m"
        return 1  # Indicates a conflict
    else
        return 0  # No conflict
    fi
}

# Function to stop a running container
stop_container() {
    container_name=$1
    echo -e "\e[33mStopping container $container_name...\e[0m"
    docker stop "$container_name" && echo -e "\e[32mContainer $container_name stopped successfully!\e[0m"
}

# Function to check if a Docker container is running
check_container_status() {
    container_name=$1
    if docker ps -q -f name="$container_name" > /dev/null; then
        echo -e "\e[32mThe container is running!\e[0m"
        container_port=$(docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' "$container_name")
        echo -e "\e[34mYou can access the app at http://$container_port\e[0m"
    else
        echo -e "\e[31mError: The container is not running.\e[0m"
    fi
}

run_docker_compose() {
    app_name=$1
    directory=$2
    target_port=$3
    echo -e "\e[36mLaunching $app_name...\e[0m"

    # Check for port conflict before proceeding
    if check_port_conflict "$target_port"; then
        read -p "Do you want to stop the existing container on port $target_port and continue? (y/n): " choice
        if [[ "$choice" == "y" || "$choice" == "Y" ]]; then
            stop_container "$container_name"
        else
            echo -e "\e[31mExiting script without launching the container.\e[0m"
            exit 1
        fi
    fi

    cd "$directory" || { echo -e "\e[31mError: Could not find the $app_name directory.\e[0m"; exit 1; }
    docker-compose up -d & show_loading_spinner
    container_name=$(docker-compose ps -q)
    check_container_status "$container_name"
}

# Ask the user and check choice
echo -e "\n\e[1mWhich app would you like to launch?\e[0m"
echo "1) multi-step-form (Port 8080)"
echo "2) visits-counter (Port 8080)"
read -p "Enter the number corresponding to the app (1 or 2): " app_choice

case "$app_choice" in
    1)
        run_docker_compose "multi-step-form" "multi-step-form" "8080"
        ;;
    2)
        run_docker_compose "visits-counter" "visits-count" "8080"
        ;;
    *)
        echo -e "\e[31mInvalid option. Please select 1 or 2.\e[0m"
        exit 1
        ;;
esac
