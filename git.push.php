<?php
exec('git add -A', $output);
exec('git commit -a -m "cl-commit"', $output);
exec('git push', $output);

print_r($output);
