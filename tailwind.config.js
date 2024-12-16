/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
  safelist: [
    'text-red-200',
    'text-red-800',
    'text-green-200',
    'text-green-800',
    'bg-red-200',
    'bg-red-700',
    'bg-green-200',
    'bg-green-700',
    'border-red-300',
    'border-red-800',
    'border-green-300',
    'border-green-800',
  ],
}
