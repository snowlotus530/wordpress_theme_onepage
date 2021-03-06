const React   = require('react');
const Select  = require("./Select.jsx");
const ODataStore = require("../../../stores/ODataStore");
const ContainedSelectorMixin = require("../../../mixins/ContainedSelectorMixin");
const ReactComponentWithPureRenderMixin = require('react/lib/ReactComponentWithPureRenderMixin');

let WpSelect = React.createClass({
  mixins: [ContainedSelectorMixin, ReactComponentWithPureRenderMixin],

  getValue(){
    return this.refs.input.getValue();
  },

  render() {
    let options = [], type=this.props.type;

    switch(type){
     case "menu": options = ODataStore.menus; break;
     case "page": options = ODataStore.pages; break;
     case "category": options = ODataStore.categories; break;
    }

    return (
      <Select 
        ref="input"
        type="select" 
        defaultValue={this.props.defaultValue}
        label={this.props.label}
        options={options} 
        onChange={this.props.onChange}/>
    );
  }
});

module.exports = WpSelect;
