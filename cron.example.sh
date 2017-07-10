#!/usr/bin/env bash

# ------------------------------------------------------------------------------
# Power and Internet monitor
# ------------------------------------------------------------------------------
#
# This script hits the remote server endpoint and generates a resource record.
# This resource record will later be modified by the beacon script on a laptop.
#
# ---
# Author: Neo Ighodaro <neo@creativitykills.co>
# Date: Saturday, 8 July 2017
# ---

ACCESS_TOKEN=SampleToken
REMOTE_SERVER_URL="http://upmonitor.dev/resources/records/generate"

## Make the silent request
curl -d "token=${ACCESS_TOKEN}" --silent --output /dev/null ${REMOTE_SERVER_URL}
