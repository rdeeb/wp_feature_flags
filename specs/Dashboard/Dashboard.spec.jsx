import React from "react";
import { shallow } from "enzyme";

import Dashboard from "../../src/components/Dashboard/Dashboard";

describe("<Dashboard />", () => {
    let component;

    beforeEach(() => {
        const routes = () => <div className={"routes"}>{"A mock for routes"}</div>;
        component = shallow(<Dashboard routes={routes} />);
    });

    describe("#render", () => {
        expect(component.find(".wrap h1")).toHaveLength(1);
        expect(component.find(".routes")).toHaveLength(1);
    });
});
