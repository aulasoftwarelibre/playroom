/** @type {import('next').NextConfig} */
module.exports = {
  serverRuntimeConfig: {
    NEXT_PUBLIC_ENTRYPOINT: process.env.NEXT_PUBLIC_ENTRYPOINT || "https://localhost",
  },
  reactStrictMode: true,
  swcMinify: true,
}
