#!/usr/bin/env bash

if [[ -z ${2} ]]
then
    echo "Usage: ./install_ubuntu.sh remote-server-url.com TokenForTheApplication /optional/path/to/install/to"
    exit 1
fi

if [[ -z ${3} ]]
then
    INSTALL_PATH="/usr/local/bin"
else
    INSTALL_PATH=${3}
fi

echo "==> Fetching monitor..."
curl -s https://raw.githubusercontent.com/neoighodaro/resource-monitor/master/public/monitor.sh -o hngmonitor
echo "==> Fetch Completed..."

echo "==> Updating permissions..."
chmod 0755 hngmonitor
echo "==> Completed updating permissions..."

echo "==> Preparing script..."
sed -i '' "s/upmonitor.dev/${1}/g" hngmonitor
sed -i '' "s/SampleToken/${2}/g" hngmonitor
sed -i '' "s/__DEBUGGING=true/__DEBUGGING=/g" hngmonitor
echo "==> Script prepared"

echo "==> Moving to installation path"
mv ./hngmonitor ${INSTALL_PATH}
echo "==> Moved script to \"${INSTALL_PATH}\""

echo "==> Installation complete. Create a cron job to call this script: hngmonitor <power|internet> <uuid>"