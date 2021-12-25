import {
  Box,
  Flex,
  Heading,
  Icon,
  Textarea,
  useStyleConfig,
} from "@chakra-ui/react";
import React from "react";
import { FaUserCircle } from "react-icons/fa";
import styled from "@emotion/styled";
import { ActivityFooter } from "./ActivityFooter";

const Description = styled(Box)`
  mask-image: linear-gradient(180deg, #000 60%, transparent);

  a {
    color: rgba(59, 130, 246);
    cursor: pointer;
  }

  a:hover {
    text-decoration: underline;
  }

  p {
    padding-top: 0.5rem;
  }

  ul {
    list-style-position: inside;
  }

  li {
    padding-top: 0.125rem;
  }
`;

export const Activity = () => {
  const styles = useStyleConfig("Activity");

  return (
    <Box sx={styles}>
      <Flex direction="column" w="full" p="4">
        <Flex experimental_spaceX="2" alignItems="center" fontSize="sm">
          <Icon as={FaUserCircle} h="5" w="5" mr="2" display="inline-block" />
          <Box as="span" fontWeight="bold">
            r/AulaSoftwareLibre
          </Box>
          <Box as="span" opacity="0.5">
            · Publicado por u/sergio hace 2 meses
          </Box>
        </Flex>
        <Heading as="h2" fontSize="2xl" fontWeight="extrabold" mt="2">
          Continuación del taller de bots
        </Heading>
        <Box fontWeight="semibold" textTransform="uppercase">
          13 oct 2017 12:00
        </Box>
        <Description mt="2" fontSize="sm" ml="4" maxH="32" overflow="hidden">
          <p>
            Si hay gente interesada se puede continuar con el taller de
            programación de bots. Algunos de los temas que se pueden tratar:
          </p>
          <ul>
            <li> Procesamiento del lenguaje natural</li>
            <li> Despliegue en servidores (heroku) </li>
            <li>
              Consumir API de terceros con acceso con autenticación por OAUTH2
              (Spotify, Google Drive)
            </li>
          </ul>

          <p>
            Es recomendable tener conocimientos de programación y del lenguaje
            Python
          </p>
        </Description>
      </Flex>
      <ActivityFooter />
    </Box>
  );
};
