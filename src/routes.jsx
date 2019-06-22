import React from "react";
import { Switch, Route } from "react-router-dom";
import { FeaturesTable } from "./components";

const routes = () => (
  <Switch>
    <Route exact component={FeaturesTable} path="/" />
  </Switch>
);

export default routes;
