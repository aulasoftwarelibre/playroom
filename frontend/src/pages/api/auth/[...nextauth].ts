import NextAuth, {NextAuthOptions} from "next-auth";

import { UCOProvider } from "../../../server";

const options : NextAuthOptions = {
  debug: true,
  pages: {
    signIn: "/signIn",
    error: "/500",
  },
  providers: [
    UCOProvider({
      clientId: process.env.CLIENT_ID ?? "",
      clientSecret: process.env.CLIENT_SECRET ?? ""
    }),
  ],
  secret: process.env.SECRET,
};

export default NextAuth(options);
