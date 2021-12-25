import { Heading } from "@chakra-ui/react";
import { Layout, Activity } from "../components";

const Index = () => (
  <Layout>
    <Heading as="h1" my="6" fontSize="2xl">
      Actividades
    </Heading>
    <Activity />
  </Layout>
);

export default Index;
