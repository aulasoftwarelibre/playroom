import { Icon } from "@chakra-ui/icons";
import { RiMoonFill, RiSunFill } from "react-icons/ri";
import { Button, useColorMode, Switch } from "@chakra-ui/react";

export const DarkModeSwitch = () => {
  const { colorMode, toggleColorMode } = useColorMode();
  const isDark = colorMode === "dark";

  return (
    <Button
      p="0"
      onClick={toggleColorMode}
      variant="ghost"
      _focus={{ border: 0 }}
    >
      {isDark ? <Icon as={RiSunFill} /> : <Icon as={RiMoonFill} />}
    </Button>
  );
};
