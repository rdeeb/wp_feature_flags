import React, { PureComponent } from "react";
import PropTypes from "prop-types";
import { Trans } from "react-i18next";

export default class Dashboard extends PureComponent {
  static propTypes = {
    routes: PropTypes.func.isRequired
  };

  constructor(props) {
    super(props);
    this.state = {
      features: []
    };
  }

  componentDidMount() {
    /*const formData = new FormData();
    formData.append("action", "get_feature_flags");

    fetch(ff_admin_dashboard.ajax_url, {
      method: "POST",
      cache: "no-cache",
      body: formData
    })
      .then(response => response.json())
      .then(response => {
        this.setState({ features: response });
      });*/
  }

  render() {
    const { routes } = this.props;

    return (
      <div className="wrap">
        <h1>
          <Trans>{"Feature Flags Dashboard"}</Trans>
        </h1>
        <hr className="wp-header-end" />
        {routes}
      </div>
    );
  }
}
