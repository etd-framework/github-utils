"use strict";

/**
 * Define any constants that need to be used application-wide
 */

// uri for API calls
export const API_ROOT = (process.env.NODE_ENV === 'development') ? 'https://api.github' : window.location.origin + '/api';