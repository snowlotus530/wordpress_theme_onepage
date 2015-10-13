import React from 'react';
import PanelGroup from 'react-bootstrap/lib/PanelGroup';
import Panel from 'react-bootstrap/lib/Panel';
import Input from '../../../shared/components/form/Input.jsx';
import AddToMenu from './menu/AddToMenu.jsx';

import "./menu/style.less";

const Menu = React.createClass({
  getInitialState(){
    return{
      menu: null
    }
  },

  handleMenu(){
    this.setState({menu: this.refs.menu.getValue()});
  },

  _renderMenuPanel(section, index){
    let title = <div>{section.title}<span className='fa fa-caret-down pull-right'></span></div>;

    return (
      <Panel key={section.key} header={title} eventKey={index}>
        <AddToMenu index={index} menu={parseInt(this.state.menu)} title={section.title} id={section.id} />
      </Panel>
    );
  },

  render() {
    let menu = {
      type    : 'menu',
      value   : '',
      label   : 'Menu Position',
      onChange: this.isFormValid
    };

    let {sections} = this.props;

    return (
      <div className="onepager-menu">
        <Input ref='menu' options={menu} onChange={this.handleMenu}/>

        {this.state.menu ?
          <PanelGroup accordion>
            { sections.map(this._renderMenuPanel) }
          </PanelGroup> :
          <p>Please select a Menu</p>
        }
      </div>
    );
  }
});

export default Menu;
