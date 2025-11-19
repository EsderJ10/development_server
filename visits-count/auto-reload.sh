#!/bin/bash

set -eu

INTERVAL=.250
ACTIVE_WID=$(xdotool search --onlyvisible --class "chrome" | head -n 1)

cleanup() {
    echo "[*] Exiting script."
    #sleep 3
    #exit 0
}

trap cleanup SIGINT

# Main loop to reload the active Chrome tab
while true; do
    echo "[*] Looking for active Chrome window..."

    #xdotool windowminimize "$ACTIVE_WID" || { echo "[!] Failed to minimize window"; continue; }

    # Activate the found window and reload the tab
    xdotool windowactivate "$ACTIVE_WID" || { echo "[!] Failed to activate window"; continue; }
    xdotool key --window "$ACTIVE_WID" 'ctrl+r' || { echo "[!] Failed to send reload key"; continue; }

    # Log the reload action and sleep
    echo "[*] Reloaded tab in window ID $ACTIVE_WID."
    sleep $INTERVAL
done
