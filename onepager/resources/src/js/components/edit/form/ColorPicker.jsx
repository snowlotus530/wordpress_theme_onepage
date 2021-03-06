const React = require('react');
const ContainedSelectorMixin = require("../../../mixins/ContainedSelectorMixin");
const ReactComponentWithPureRenderMixin = require('react/lib/ReactComponentWithPureRenderMixin');
const tinycolor = require("tinycolor2");
const $ = jQuery; //jshint ignore:line
window.tinycolor = tinycolor; //jshint ignore:line

let ColorPicker = React.createClass({
  mixins: [ContainedSelectorMixin, ReactComponentWithPureRenderMixin],
  getInitialState(){
    let bgColor = this.props.defaultValue;

    return {
      textColor: this.getTextColor(bgColor),
      bgColor: bgColor
    };
  },

  getValue(){
    return React.findDOMNode(this.refs.input).value;
  },

  getTextColor(bgColor){
    let rgb = tinycolor(bgColor).toRgb();
    
    if(rgb.a < 0.5){
      return tinycolor({
        r: 0,
        g: 0,
        b: 0,
      }).toString();      
    }

    return tinycolor({
      r: 255 - rgb.r,
      g: 255 - rgb.g,
      b: 255 - rgb.b,
      a: 1
    }).toString();
  },

  onChange(){
    let bgColor = this.getValue();
    let textColor = this.getTextColor(bgColor);

    this.setState({textColor, bgColor});
    this.props.onChange();
  },

  componentDidMount() {
    $( this.getSelector(".op-colorpicker") )
      .colorpicker()
      .on("changeColor.colorpicker, .color-icon", this.onChange);
  },

  componentWillUnmount(){
		$( this.getSelector(".op-colorpicker") ).unbind();
  },

  render() {
      let style = {background: this.state.bgColor, color: this.state.textColor};
      return (
      	<div ref="container">
          <label className="control-label">{this.props.label}</label>					
			    <div className="cp-container">
            <input 
              {...this.props} 
              style={style} 
              ref="input" 
              type="text" 
              className={"form-control op-colorpicker "+this.props.className}/>
            <span style={style} className="fa fa-tint color-icon"></span>
          </div>
      	</div>
      );
  }
});

module.exports = ColorPicker;
