#!/bin/bash
TIMEOFEXECUTION=$(date);
echo -e "
<HTML>
<HEAD>
<TITLE>
Test Of Phpcron Command Execution
</TITLE>
</HEAD>
<BODY>
The test command was executed by Phpcron on $TIMEOFEXECUTION
</BODY>
</HTML>
" > phpcron_test.html;



