const routes = [];

const route = (routeName, params = [], absolute = true) => {
  const _route = routes[routeName];
  if (_route == null) throw "Requested route doesn't exist";

  let uri = _route.uri;

  const matches = uri.match(/{[\w]+\??}/g) || [];
  const optionals = uri.match(/{[\w]+\?}/g) || [];

  const requiredParametersCount = matches.length - optionals.length;

  if (params instanceof Array) {
    if (params.length < requiredParametersCount) throw "Missing parameters";

    for (let i = 0; i < requiredParametersCount; i++)
      uri = uri.replace(/{[\w]+\??}/, params.shift());

    for (let i = 0; i < params.length; i++)
      uri += (i ? "&" : "?") + params[i] + "=" + params[i];
  } else if (params instanceof Object) {
    let extraParams = matches.reduce((ac, match) => {
      let key = match.substring(1, match.length - 1);
      let isOptional = key.endsWith("?");
      if (params.hasOwnProperty(key.replace("?", ""))) {
        uri = uri.replace(new RegExp(match.replace("?", "\\?"), "g"), params[key.replace("?", "")]);
        delete ac[key.replace("?", "")];
      } else if (isOptional) {
          uri = uri.replace("/" + new RegExp(match, "g"), "");
      }
      return ac;
    }, params);

    Object.keys(extraParams).forEach((key, i) => {
      uri += (i ? "&" : "?") + key + "=" + extraParams[key];
    });
  }

  if (optionals.length > 0) {
    for (let i in optionals) {
      uri = uri.replace("/" + optionals[i], "");
    }
  }

  if (uri.includes("}")) throw "Missing parameters";

  if (absolute && process.env.MIX_APP_URL)
    return process.env.MIX_APP_URL + "/" + uri;
  return "/" + uri;
};

export { route };
