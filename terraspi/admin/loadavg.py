
#!/usr/bin/env python
# -*- coding: utf-8 -*-
# edit
import sys


loadavg = open("/proc/loadavg").readline().split(" ")[:3]

print loadavg

sys.exit(1)

