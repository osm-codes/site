---- Bolar como fazer a carga automática de varios gits de SQL + Datasets
-- 1. sequência de scripts SQL via makefile.
-- 2.

-- conferir bk com tudo.
-- DROP SCHEMA IF EXISTS geocode CASCADE;
-- CREATE SCHEMA geocode; -- encode/decode functions after PostGIS

-- definir já em JSON ou primeiro record depois JSON?
-- o melhor é record, já que row_to_json ou to_jsonb() fazem o final.

-- types: sj=simple json, fullj = full json, stddecode = table
CREATE TYPE geocode.stddecode (
  area float,
  lat float,
  lon float,
  geom geometry
);

CREATE or replace FUNCTION geocode.stddecode_geohash(
  p_geohash text,
  p_tr boolean DEFAULT true
) RETURNS geocode.stddecode as $f$
  SELECT area, st_y(ct) lat, ST_X(ct) lon, geom
  FROM (
    SELECT st_area(geom,true) area, st_centroid(geom) ct, geom
    FROM (
      SELECT ST_SetSRID(
        ST_GeomFromGeoHash(CASE
          WHEN $2 IS NULL THEN p_geohash
          ELSE translate(p_geohash,'BCDFGHJKLMNPQRSTUVWXYZ','bcdefghjkmnpqrstuvwxyz')
        END)
        ,4326
      ) -- \st_setSRID
    ) t(geom)
  ) t2
$f$ LANGUAGE SQL IMMUTABLE;

CREATE or replace FUNCTION geocode.sj_geohash(
  p_geohash text
) RETURNS JSONb as $wrap$
  SELECT to_jsonb(t2)
  FROM (
   SELECT area,  lat,  lon,  ST_AsGeoJSON(geom,6) gjs
   FROM geocode.stddecode_geohash($1) t
  ) t2
$wrap$ LANGUAGE SQL IMMUTABLE;

/*  to test faster
CREATE or replace FUNCTION geocode.sj_geohash(
  p_geohash text
) RETURNS JSONb as $f$
  SELECT jsonb_build_object( 'area',area,  'lat',ST_Y(ct),  'lon',ST_X(ct) )
  FROM (
    SELECT st_area(geom,true) area, st_centroid(geom) ct, geom
    FROM (
      SELECT ST_SetSRID(ST_GeomFromGeoHash(p_geohash),4326)
    ) t(geom)
  ) t2
$f$ LANGUAGE SQL IMMUTABLE;

function geocode.stddecode_olc(p_olc text)
  SELECT area, st_y(ct) lat, ST_X(ct) lon, geom
...

function geocode.stddecode_s2geom(p_olc text)
  SELECT area, st_y(ct) lat, ST_X(ct) lon, geom
...

function geocode.stddecode_h3uber(p_olc text)
  SELECT area, st_y(ct) lat, ST_X(ct) lon, geom
...
*/



/*


sp-spa,São Paulo (SP)

-23.561618,-46.655996);">MASP</a>,
-23.550375,-46.633937);">Marco-zero-SP</a>,
-23.625486,-46.660856);">Aeroporto</a>, ...
030333303320,03033321331G, 03033330220G, 03033330221G, 03033330230G, 03033330231G, 03033330320G, 03033330321G,
03033321331H, 03033330220H, 03033330221H, 03033330230H, 03033330231H, 03033330320H,
03033330233G, 03033330322G,
03033330322H, 03033330233H,
03033332100G, 03033332011G,
03033330303H, 03033330321G, 03033330321H, 03033330323G,
0303332131233H,03033321313H, 03033330202H, 03033330203H, 03033330212H, 03033330213H


pr-cur,Curitiba (PR)
-25.416667,-49.25);">Centro</a>,
-25.404903,-49.230165);">Aeroporto</a>, ...
030332113331H, 030332113333G, 030332113333H, 030332131110G, 030332113332H, 030332113332G, 030332113330H, 030332113330G, 030332113321G, 030332113321H, 030332113323G, 030332113323H, 030332131101G, 030332131100G, 030332113322H, 030332113322G, 030332113320H, 030332113320G, 030332113231G, 030332113231H, 030332113233G, 030332113233H, 0303321310, 030332113232H, 030332113232G, 030332113230H, 030332113221G, 030332113221H, 030332113223G, 030332113223H, 030332113220G, 030332113220H


pa-atm,Altamira (PA)
-3.2069074,-52.2188004);">Prefeitura</a>,
-3.2535258,-52.249368);">Aeroporto</a>, ...
031330312313220, 031330312303311, 03133031231212, 03133031231203, 03133031231231,
03133031231230,03133031231232,03133031231322,03133031231233,03133031231323,
031330301G, 031330301H, 031330303G, 031330303H, 031330312H, 031330330G, 031330312G, 031330313G, 031330313H,
0313203G, 0313201H, 0313201G, 0313210G, 0313210H,
0313212G, 0313213G, 0313211H, 0313211G, 0313300G,
0313300H, 0313302G,03133023G

*/
