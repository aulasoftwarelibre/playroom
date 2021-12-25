import {OAuthConfig, OAuthUserConfig} from "next-auth/providers";

export interface UcoProfile {
  preferred_username: string,
  name: string,
  email: string,
}

export function UCOProvider<P extends UcoProfile>(
  options: OAuthUserConfig<P>
): OAuthConfig<P> {
  return {
    id: "uco",
    name: "Universidad de Cordoba",
    type: "oauth",
    authorization: {
      url: "https://identidad.uco.es/simplesaml/module.php/oidc/authorize.php?response_type=code",
      params: { scope: "email profile" }
    },
    token: "https://identidad.uco.es/simplesaml/module.php/oidc/access_token.php",
    userinfo: "https://identidad.uco.es/simplesaml/module.php/oidc/userinfo.php",
    profile: (profile: P) => {
      return {
        id: profile.preferred_username,
        name: profile.name,
        email: profile.email,
      };
    },
    options,
  };
}

export default UCOProvider;
