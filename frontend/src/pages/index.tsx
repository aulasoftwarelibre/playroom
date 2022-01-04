import { Heading } from "@chakra-ui/react";

import { GET_ALL_ROOMS } from "../api/rooms";
import { Activity, Layout } from "../components";
import { initializeApollo } from "../lib/apollo";

const Index = () => (
  <Layout>
    <Heading as="h1" my="6" fontSize="2xl">
      Actividades
    </Heading>
    <Activity />
  </Layout>
);

export async function getServerSideProps() {
  const apolloClient = initializeApollo();

  await apolloClient.query({
    query: GET_ALL_ROOMS,
  });

  return {
    props: {
      initialApolloState: apolloClient.cache.extract(),
    },
  };
}

export default Index;
