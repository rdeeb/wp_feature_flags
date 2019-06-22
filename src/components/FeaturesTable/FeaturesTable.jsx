import React, { PureComponent } from "react";
import PropTypes from "prop-types";
import Classnames from "classnames";
import { Trans } from "react-i18next";

import "./styles.scss";

export default class FeaturesTable extends PureComponent {
  static propTypes = {
    features: PropTypes.array.isRequired
  };

  constructor(props) {
    super(props);
    this.state = {
      sort: ""
    };
  }

  handleToggleSortOrder = () => {
    const { sort } = this.state;
    this.setState({ sort: sort === "desc" ? "asc" : "desc" });
  };

  renderHeaderRow = () => {
    const { sort } = this.state,
      firstColumnClasses = Classnames({
        "manage-column": true,
        "column-title": true,
        "column-primary": true,
        sortable: sort === "",
        sorted: sort !== "",
        desc: sort === "desc",
        asc: sort === "asc"
      });

    return (
      <tr>
        <th className={firstColumnClasses} id="name" scope="col" onClick={this.handleToggleSortOrder}>
          <a>
            <span>
              <Trans>{"Name"}</Trans>
            </span>
            <span className="sorting-indicator" />
          </a>
        </th>
        <th className="manage-column column-actions" id="actions" scope="col">
          <span>
            <Trans>{"Actions"}</Trans>
          </span>
        </th>
      </tr>
    );
  };

  renderTableBody = () => {
    const { features } = this.props;
    if (features.length === 0) {
      return (
        <tr className="no-items">
          <td className="colspanchange" colSpan="5">
            <Trans>{"There are no configured Feature Flags"}</Trans>
          </td>
        </tr>
      );
    }

    return features.map(feature => {
      return (
        <tr className="type-feature-flag" id={feature.name} key={feature.name}>
          <td className="title column-name column-primary" data-colname="Name">
            {feature.name}
          </td>
          <td className="actions column-actions" data-colname="Actions">
            <input className="button button-primary" id="submit" name="submit" type="submit" value="Edit" />
          </td>
        </tr>
      );
    });
  };

  render() {
    return (
      <React.Fragment>
        <h2 className="screen-reader-text">
          <Trans>{"Feature Flags List"}</Trans>
        </h2>
        <table className="wp-list-table widefat striped feature-flags">
          <thead>{this.renderHeaderRow()}</thead>
          <tbody id="the-list">{this.renderTableBody()}</tbody>
          <tfoot>{this.renderHeaderRow()}</tfoot>
        </table>
      </React.Fragment>
    );
  }
}
