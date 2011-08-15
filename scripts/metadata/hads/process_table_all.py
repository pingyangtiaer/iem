import iemdb
import os
HADS = iemdb.connect('hads')
hcursor = HADS.cursor()
hcursor2 = HADS.cursor()
MESOSITE = iemdb.connect('mesosite')

missing = []
hcursor.execute("""
SELECT distinct nwsli from unknown WHERE network ~* 'DCP'
""")
for row in hcursor:
  missing.append( row[0] )

stations = {}
for line in open('all_dcp_defs.txt'):
  tokens = line.split("|")
  if len(tokens) < 10:
    continue
  (d,m,s) = tokens[5].split()
  lat = float(d) + ((float(s)/60.0 + float(m)) / 60.)  
  (d,m,s) = tokens[6].split()
  lon = float(d) - ((float(s)/60.0 + float(m)) / 60.)  

  stations[tokens[1]] = {
    'name': tokens[9].replace('"', '').replace("'","").title(),
    'state': tokens[3].strip(),
    'lon' : lat,
    'lat' : lon,
    'id': tokens[1]
    }


for miss in missing:
  if not stations.has_key(miss):
    print 'Unknown', miss
    continue
  data = stations[miss]
  sql = "INSERT into stations(id, synop, name, state, country, network, online,\
         geom, plot_name \
         ) VALUES ('%(id)s', 99999, '%(name)s', '%(state)s', 'US', '%(state)s_DCP', 't',\
         'SRID=4326;POINT(%(lon)s %(lat)s)',  '%(name)s')" % data

  mcursor = MESOSITE.cursor()
  try:
    mcursor.execute(sql)
  except:
    mcursor.close()
  MESOSITE.commit()


  cmd = "/mesonet/python/bin/python /mesonet/www/apps/iemwebsite/scripts/util/addSiteMesosite.py %s_DCP %s" % (data['state'], miss)
  os.system(cmd)

  hcursor2.execute("""
  DELETE from unknown where nwsli = %s
  """, (miss,))

HADS.commit()
