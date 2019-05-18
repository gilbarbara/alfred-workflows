. workflowHandler.sh

plist="/Library/LaunchDaemons/com.crashplan.engine.plist"

if [ -f $plist ]; then

	# addResult "uid" "arg" "title" "subtitle" "icon" "valid" "autocomplete"
	addResult "stop" "stop" "Stop CrashPlan" "" "icon-stop.png" "yes" "autocomplete"
	addResult "start" "start" "Start CrashPlan" "" "icon-start.png" "yes" "autocomplete"

	getXMLResults

else
	addResult "not-installed" "" "CrashPlan is not installed" "" "icon.png" "yes" "autocomplete"

	getXMLResults
fi
