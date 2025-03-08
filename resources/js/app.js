const maptiler_apikey = import.meta.env.VITE_MAPTILER_API_KEY;

export {maptiler_apikey};

import './tools/functions';

import './trip';

//import './geocoding';

import './common';

import.meta.glob([
    '../images/**',
  ]);