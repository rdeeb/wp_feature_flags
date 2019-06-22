import React from "react";
import ReactDom from "react-dom";
import "./i18n";

import { Dashboard } from "./components";
import routes from "./routes";

const anchorPoint = document.getElementById("wp-feature-flags-dashboard");

// Only attempt to render the dashboard if we have the anchor point
if (anchorPoint) {
  ReactDom.render(<Dashboard routes={routes} />, anchorPoint);
}
