#!/usr/bin/env bash

# ------------------------------------------------------------------------------
# Power and Internet monitor
# ------------------------------------------------------------------------------
#
# The script is intended to monitor when Power and Internet goes out. You can
# read more in the readme file included in the repository.
#
# ---
# Author: Neo Ighodaro <neo@creativitykills.co>
# Date: Saturday, 8 July 2017
# ---

# ------------------------------------------------------------------------------
# Configuration. You can edit these variables
# ------------------------------------------------------------------------------

ACCESS_TOKEN=
REMOTE_SERVER_URL="http://upmonitor.dev/resources/status"
NOTIFICATION_ERROR_MESSAGE="Watchdog cannot connect to ${REMOTE_SERVER_URL}. Status Code: :STATUS_CODE:"


# ------------------------------------------------------------------------------
# Validation before proceeding
# ------------------------------------------------------------------------------

MONITOR_TYPE=${1}
RESOURCE_UUID=${2}

if ([[ ${MONITOR_TYPE} != "power" ]] && [[ ${MONITOR_TYPE} != "internet" ]]) || [[ -z ${RESOURCE_UUID} ]]
then
    echo "Usage: monitor <power|internet> <uuid>"
    exit 1
fi

if [[ ! ${RESOURCE_UUID} =~ ^\{?[A-F0-9a-f]{8}-[A-F0-9a-f]{4}-[A-F0-9a-f]{4}-[A-F0-9a-f]{4}-[A-F0-9a-f]{12}\}?$ ]]
then
    echo "Error: Invalid UUID specified. Please use the UUID given by the monitor application."
    exit 1
fi


# ------------------------------------------------------------------------------
# Global helper functions
# ------------------------------------------------------------------------------

## Displays a notification on the host machine
__display_notification() {
    NOTIFICATION_ERROR_MESSAGE=${NOTIFICATION_ERROR_MESSAGE/:STATUS_CODE:/${STATUS_CODE}}

    case $(uname) in
        "Darwin")
            osascript -e "display notification \"${NOTIFICATION_ERROR_MESSAGE}\" sound name \"Frog\" with title \"Watchdog\""
            ;;
        "Linux")
            notify-send ${NOTIFICATION_ERROR_MESSAGE/:STATUS_CODE:/${STATUS_CODE}}
            ;;
    esac
}

## Sends the resource status to the remote server
__send_resource_status() {
    if [[ -z ${RESOURCE_STATUS} ]] || ([[ ${RESOURCE_STATUS} != "up" ]] && [[ ${RESOURCE_STATUS} != "down" ]])
    then
        echo "Error: The resource status must be either \"up\" or \"down\""
        exit 1
    fi

    STATUS_CODE=$(curl --write-out "%{http_code}" -d "uuid=${RESOURCE_UUID}&status=${RESOURCE_STATUS}" --silent --output /dev/null ${REMOTE_SERVER_URL})
}

## Sends the resource status to the remote server, and displays a notification if it fails to send the status
__send_resource_status_with_notification_on_failure() {
    __send_resource_status

    if [[ ${STATUS_CODE} != "200" ]]
    then
        __display_notification
    fi
}


# ------------------------------------------------------------------------------
# Resources logic
# ------------------------------------------------------------------------------

## 🌏
__monitor_internet() {

    ## Checks the connection status and echos the result
    __check_connection_status() {
    	PING_STATUS=$(ping -c 2 -W 2 google.com 2>/dev/null)

        if [[ ! -z $(echo ${PING_STATUS} | grep -w "0.0% packet loss") ]]
        then
            echo "up"
        elif [[ ! -z $(echo ${PING_STATUS} | grep -w "100.0% packet loss") ]]
        then
    		echo "down"
    	fi
    }

    RESOURCE_STATUS=$(__check_connection_status)

    __send_resource_status_with_notification_on_failure
}

## ⚡️
__monitor_power() {

    ## Error message when there is no battery
    __exit_no_battery() {
        echo "Error: No battery found! What is this magic! Sensei!"
        exit 1
    }

    ## Get the battery details
    __get_battery_details() {
        case $(uname) in
            "Darwin")
                BATTERY_DETAILS=$(pmset -g batt)

                if ! echo "${BATTERY_DETAILS}" | grep -q InternalBattery
                then
                    __exit_no_battery
                fi

                CHARGED=$(echo ${BATTERY_DETAILS} | grep -w 'charged')
                CHARGING=$(echo ${BATTERY_DETAILS} | grep -w 'AC Power')
                DISCHARGING=$(echo ${BATTERY_DETAILS} | grep -w 'Battery Power')
                ;;
            "Linux")
                BATTERY_DETAILS=$(LC_ALL=en_US.UTF-8 upower -i $(upower -e | grep "BAT"))

                if [[ -z ${BATTERY_DETAILS} ]]
                then
                    __exit_no_battery
                fi

                CHARGED=$(echo ${BATTERY_DETAILS} | grep "state" | grep -w "fully-charged")
                CHARGING=$(echo ${BATTERY_DETAILS} | grep "state" | grep -w "charging")
                DISCHARGING=$(echo ${BATTERY_DETAILS} | grep "state" | grep -w "discharging")
                ;;
        esac

        if [[ ! -z ${CHARGED} ]] || [[ ! -z ${CHARGING} ]]
        then
            echo "up"
        elif [ ! -z ${DISCHARGING} ]
        then
            echo "down"
        fi
    }

    RESOURCE_STATUS=$(__get_battery_details)

    __send_resource_status_with_notification_on_failure
}


# ------------------------------------------------------------------------------
# Capua!!! Shall I begin?!
# ------------------------------------------------------------------------------

case ${MONITOR_TYPE} in
    "internet")
        __monitor_internet
        ;;
    "power")
        __monitor_power
        ;;
esac