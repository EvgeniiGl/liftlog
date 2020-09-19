export const isProduction = process.env.NODE_ENV === 'production';

console.log('isProduction-- ', isProduction);
export const SOCKET_URL = isProduction ? "http://62.231.174.218:8086" : "http://localhost:8086";

export const baseUrl = isProduction ? 'http://62.231.174.218:8085' : `http://liftlog/public/`;
