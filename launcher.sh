#!/bin/bash

set -u

# --- Configuration & Styling ---
BOLD="\e[1m"
RESET="\e[0m"
RED="\e[31m"
GREEN="\e[32m"
YELLOW="\e[33m"
BLUE="\e[34m"
CYAN="\e[36m"
MAGENTA="\e[35m"
GRAY="\e[90m"

# App Definitions (Name | Folder | Port)
declare -A APPS
APPS["1,Name"]="Multi-step Form"
APPS["1,Dir"]="multi-step-form"
APPS["1,Port"]="8080"

APPS["2,Name"]="Visits Counter"
APPS["2,Dir"]="visits-count"
APPS["2,Port"]="8080"

# Detect Docker Compose Version
if docker compose version >/dev/null 2>&1; then
    COMPOSE_CMD="docker compose"
else
    COMPOSE_CMD="docker-compose"
fi

# --- Helper Functions ---

log_info() { echo -e "${BLUE}ℹ ${RESET} $1"; }
log_success() { echo -e "${GREEN}✔ ${RESET} $1"; }
log_warn() { echo -e "${YELLOW}⚠ ${RESET} $1"; }
log_error() { echo -e "${RED}✖ $1${RESET}"; }

# Restore cursor if script is interrupted (Ctrl+C)
cleanup_exit() {
    tput cnorm
    echo -e "\n${GRAY}Script interrupted. Exiting.${RESET}"
    exit 1
}
trap cleanup_exit SIGINT

# Check if Docker Daemon is actually running (Windows Users)
check_docker_daemon() {
    if ! docker info > /dev/null 2>&1; then
        log_error "Docker Desktop is not running!"
        log_info "Please start Docker and try again."
        exit 1
    fi
}

show_spinner() {
    local pid=$1
    local delay=0.1
    local spinstr='|/-\'
    tput civis # Hide cursor
    while kill -0 "$pid" 2>/dev/null; do
        local temp=${spinstr#?}
        printf "[%c]  " "$spinstr"
        local spinstr=$temp${spinstr%"$temp"}
        sleep $delay
        printf "\b\b\b\b\b\b"
    done
    printf "    \b\b\b\b"
    echo ""
    tput cnorm # Restore cursor
}

wait_for_health() {
    local port=$1
    local max_retries=30
    local count=0

    echo -en "${BOLD}[*] Waiting for app to boot... ${RESET}"
    
    # Loop until the URL returns an HTTP status or we timeout
    while ! curl -s "http://localhost:$port" > /dev/null; do
        if [ $count -ge $max_retries ]; then
            echo ""
            log_warn "App is taking a long time to start."
            return 1
        fi
        count=$((count+1))
        sleep 1
    done
    echo -e "${GREEN}Ready!${RESET}"
    return 0
}

launch_app() {
    local app_name=$1
    local dir=$2
    local port=$3

    echo -e "\n${BOLD}Launching: $app_name${RESET}"
    echo "------------------------------------------------"

    if [[ ! -d "$dir" ]]; then
        log_error "Directory './$dir' not found."
        return
    fi

    # Handle port conflict asking the user
    local conflict
    conflict=$(docker ps --format "{{.Names}}\t{{.Ports}}" | grep -E ":$port->" | awk '{print $1}' | head -n 1)
    
    if [[ -n "$conflict" ]]; then
        log_warn "Port $port occupied by container: ${MAGENTA}$conflict${RESET}"
        read -p "$(echo -e "${CYAN}? Stop existing container? (y/N): ${RESET}")" choice
        if [[ "$choice" =~ ^[Yy]$ ]]; then
            docker stop "$conflict" >/dev/null 2>&1 && log_success "Stopped $conflict"
        else
            log_error "Cannot proceed with port conflict."; return
        fi
    fi

    cd "$dir" || return
    log_info "Building containers..."
    $COMPOSE_CMD up -d --build >/dev/null 2>&1 &
    show_spinner $!

    # Health check
    if [ $? -eq 0 ]; then
        wait_for_health "$port"
        echo ""
        log_success "Successfully deployed!"
        echo -e "   ${BOLD}➜ Access here:${RESET} ${BLUE}http://localhost:$port${RESET}"
        
        # Log viewing option
        read -p "$(echo -e "\n${GRAY}? View logs now? (y/N): ${RESET}")" log_choice
        if [[ "$log_choice" =~ ^[Yy]$ ]]; then
             $COMPOSE_CMD logs -f
        fi
    else
        log_error "Docker Compose failed."
    fi
    
    # Return to root for next operation
    cd ..
}

cleanup_resources() {
    echo -e "\n${BOLD}Cleaning up resources...${RESET}"
    # Iterate over registered apps and try to down them
    for key in "${!APPS[@]}"; do
        if [[ $key == *"Dir"* ]]; then
            dir=${APPS[$key]}
            if [[ -d "$dir" ]]; then
                cd "$dir" || continue
                echo -n "  Stopping $dir... "
                $COMPOSE_CMD down >/dev/null 2>&1
                echo -e "${GREEN}Done${RESET}"
                cd ..
            fi
        fi
    done
    log_success "All apps stopped and networks removed."
}

# --- Main Loop ---

check_docker_daemon

while true; do
    clear
    echo -e "${MAGENTA}"
    echo "======= DWES Launcher - Docker Containers ======="
    echo -e "${RESET}"
    
    echo -e "1) Multi-step Form   ${GRAY}(Port 8080)${RESET}"
    echo -e "2) Visits Counter    ${GRAY}(Port 8080)${RESET}"
    echo -e "3) Stop All & Clean  ${GRAY}(Remove Containers)${RESET}"
    echo "4) Quit"
    echo ""
    read -p "Select an option: " choice

    case $choice in
        1) launch_app "${APPS["1,Name"]}" "${APPS["1,Dir"]}" "${APPS["1,Port"]}" ;;
        2) launch_app "${APPS["2,Name"]}" "${APPS["2,Dir"]}" "${APPS["2,Port"]}" ;;
        3) cleanup_resources ;;
        4) log_info "Goodbye!"; exit 0 ;;
        *) log_error "Invalid option." ;;
    esac
    
    echo "------------------------------------------------"
    echo ""
    read -p "Press [Enter] to return to menu..."
done
