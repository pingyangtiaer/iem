
import psycopg2.extras
import datetime
import numpy as np
from pyiem.plot import MapPlot
import matplotlib.cm as cm

PDICT ={'high': 'High temperature',
        'low': 'Low Temperature'}


def get_description():
    """ Return a dict describing how to call this plotter """
    d = dict()
    d['arguments'] = [
        dict(type='date', name='date1', default='2014/09/01', label='From Date (ignore year):',
             min="2014/01/01"), # Comes back to python as yyyy-mm-dd
        dict(type='date', name='date2', default='2014/09/22', label='To Date (ignore year):',
             min="2014/01/01"), # Comes back to python as yyyy-mm-dd
        dict(type='select', name='varname', default='high',
             label='Which metric to plot?', options=PDICT),
        
    ]
    return d

def plotter( fdict ):
    """ Go """
    pgconn = psycopg2.connect(database='coop', host='iemdb', user='nobody')
    cursor = pgconn.cursor(cursor_factory=psycopg2.extras.DictCursor)

    date1 = datetime.datetime.strptime(fdict.get('date1', '2014-09-01'), 
                                       '%Y-%m-%d')
    date2 = datetime.datetime.strptime(fdict.get('date2', '2014-09-22'), 
                                       '%Y-%m-%d')
    date1 = date1.replace(year=2000)
    date2 = date2.replace(year=2000)

    varname = fdict.get('varname', 'low')

    cursor.execute("""
    WITH t2 as (
         SELECT station, high, low from ncdc_climate81 WHERE
         valid = %s
    ), t1 as (
        SELECT station, high, low from ncdc_climate81 where
        valid = %s
    ), data as (
        SELECT t2.station, t1.high as t1_high, t2.high as t2_high, 
        t1.low as t1_low, t2.low as t2_low from t1 JOIN t2 on 
        (t1.station = t2.station)
    )
    SELECT d.station, ST_x(geom) as lon, ST_y(geom) as lat,
    t2_high -  t1_high as high, t2_low - t1_low as low from data d JOIN
    stations s on (s.id = d.station) where s.network = 'NCDC81'
    """, (date2, date1))
    vals = []
    lons = []
    lats = []
    for row in cursor:
        lats.append( row['lat'] )
        lons.append( row['lon'] )
        vals.append( row[varname])
  
    days = int((date2 - date1).days)
    extent = int( max( abs(min(vals)), abs(max(vals))) )
    m = MapPlot(sector='conus', 
                title='%s Day Change in %s NCDC 81 Climatology' % (days,
                                    PDICT[varname]),
                subtitle='from %s to %s' % (date1.strftime("%-d %B"),
                                            date2.strftime("%-d %B"))
                )
    cmap = cm.get_cmap("RdBu_r")
    m.contourf(lons, lats, vals, np.arange(0-extent,extent+1, 2), cmap=cmap,
               units='F')

    return m.fig
