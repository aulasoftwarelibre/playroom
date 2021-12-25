import { extendTheme, ColorMode } from "@chakra-ui/react";
import {createBreakpoints, StyleFunctionProps} from "@chakra-ui/theme-tools";

const fonts = { body: "Nunito", heading: "Nunito" };

const breakpoints = createBreakpoints({
  sm: "640px",
  md: "768px",
  lg: "1024px",
  xl: "1280px",
  "2xl": "1536px",
});

const colors = {
  black: "#16161D",
  skin: {
    light: {
      bg: {
        body: "#F3F4F6" /* gray-100 #F3F4F6 */,
        base: "#FFFFFF" /* white */,
        accent: "#FFFFFF" /* white */,
        primary: "#7C3AED", /* purple-600 */
      },
      border: {
        base: "#E5E7EB" /* gray-700 #374151 */,
        accent: "#E5E7EB" /* gray-200 #E5E7EB */,
      },
      text: {
        base: "#374151" /* gray-700 #374151 */,
        inverted: "#E5E7EB" /* gray-200 #E5E7EB */,
        primary: "#FFFFFF" /* white */,
      },
    },
    dark: {
      bg: {
        body: "#111827" /* gray-900 #111827 */,
        base: "#1F2937" /* gray-700 #374151 */,
        accent: "#374151" /* gray-600 #4B5563 */,
        primary: "#7C3AED", /* purple-600 */
      },
      border: {
        base: "#374151" /* gray-700 #374151 */,
        accent: "#E5E7EB" /* gray-200 #4B5563 */,
      },
      text: {
        base: "#E5E7EB" /* gray-200 #E5E7EB */,
        inverted: "#E5E7EB" /* gray-200 #E5E7EB */,
        primary: "#FFFFFF" /* white */,
      },
    },
  },
};



const components  = {
  Activity: {
    baseStyle: ({colorMode}: StyleFunctionProps) => ({
      bgColor: `skin.${colorMode}.bg.base`,
      border: "1px",
      borderColor: `skin.${colorMode}.border.base`,
      textColor: `skin.${colorMode}.text.base`,
    }),
  },
  Button: {
    variants: {
      login:  ({colorMode}: StyleFunctionProps) => ({
        bgColor: `skin.${colorMode}.bg.primary`,
        textColor: `skin.${colorMode}.text.primary`,
        width: "100%",
        _hover: {
          opacity: "80%"
        }
      }),
    }
  },
  Layout: {
    baseStyle: ({ colorMode }: StyleFunctionProps) => ({
      bgColor: `skin.${colorMode}.bg.body`,
    }),
  },
  Navbar: {
    baseStyle: ({ colorMode }: StyleFunctionProps) => ({
      color: `skin.${colorMode}.text.base`,
      bgColor: `skin.${colorMode}.bg.base`,
    }),
  },
  NavbarButton: {
    baseStyle: ({ colorMode }: StyleFunctionProps) => ({
      color: `skin.${colorMode}.text.base`,
      bgColor: `skin.${colorMode}.bg.base`,
      _focus: {
        border: "0",
      },
    }),
  },
  NavbarSearchBox: {
    baseStyle: ({ colorMode }: StyleFunctionProps) => ({
      color: `skin.${colorMode}.text.base`,
      bgColor: `skin.${colorMode}.bg.accent`,
    }),
  },
  Text: {
    baseStyle: ({ colorMode }: StyleFunctionProps) => ({
      color: `skin.${colorMode}.text.base`,
    }),
  },
};

const theme = extendTheme({
  colors,
  fonts,
  breakpoints,
  components,
});

export default theme;
