#!/usr/bin/env python3
import subprocess
import sys
import re

def run(cmd):
    subprocess.check_call(cmd, shell=True)

# This uses the older filter-branch; make sure you have a backup!
filter_cmd = r"""
git filter-branch --msg-filter '
  python3 - <<PY
import sys, re
text = sys.stdin.read()
# Drop any lines starting with Co-authored-by:
out = "\n".join(
    l for l in text.splitlines()
    if not re.match(r"\s*Co-authored-by:", l)
)
sys.stdout.write(out)
PY
' -- --all
"""

print("Rewriting history to remove Co-authored-by lines…")
run(filter_cmd)
print("Done! Don’t forget to `git push --force` your branches.")
