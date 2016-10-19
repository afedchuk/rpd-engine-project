@echo off
IF EXIST "%1.php" GOTO DIRECT
bin\cake %*
GOTO END
:DIRECT
"%1.php" %2 %3 %4 %5 %6 %7 %8 %9
:END
