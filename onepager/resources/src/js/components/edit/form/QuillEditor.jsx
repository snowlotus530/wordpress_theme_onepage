const React       = require('react');
const PureMixin   = require('react/lib/ReactComponentWithPureRenderMixin');
const ReactQuill    = require('react-quill');

let QuillControl = React.createClass({
  mixins: [PureMixin],

  getInitialState(){
    return {
      value: this.props.defaultValue //anti pattern
    };
  },

  getValue(){
    return this.state.value;
  },

  onChange(value) {
    this.setState({ value: value });
    this.props.onChange();
  },

  render() {
        // <ReactQuill>
        //   <ReactQuill.Toolbar key="toolbar" ref="toolbar" items={ReactQuill.Toolbar.defaultItems} />
        //   <div key="editor" ref="editor" className="quill-contents" dangerouslySetInnerHTML={{ __html: this.props.defaultValue }} />
        // </ReactQuill>
    return (
      <div>
        <label>{this.props.label}</label>
        <ReactQuill theme="snow" value={this.props.defaultValue} onChange={this.onChange} />
  

      </div>
    );
  }
});

module.exports = QuillControl;
