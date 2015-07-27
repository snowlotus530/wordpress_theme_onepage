const _               = require('underscore');
const React           = require('react');
const cx              = require('classnames');
const SortableMixin   = require('sortablejs/react-sortable-mixin');
const Button          = require('react-bootstrap/lib/Button');
const SectionLi       = require('./Section.jsx');
const BlockCollection = require('../blocks/BlockCollection.jsx');
const AppStore        = require('../../AppStore.js');
const AppActions      = require('../../AppActions.js');
// const PureMixin           = require('../../../mixins/PureMixin.js');
const PureMixin = require('react/lib/ReactComponentWithPureRenderMixin');
const Footer    = require('./Footer.jsx');


let SectionList = React.createClass({
  //TODO: need pure mixin
  mixins: [SortableMixin],

  propTypes: {
    activeSectionIndex: React.PropTypes.number,
    blocks: React.PropTypes.array,
    sections: React.PropTypes.array
  },

  getInitialState(){
    return {
      showBlocks: false
    };
  },

  setBodyClass(){
    if (this.props.sections.length === 0) {
      jQuery('body').addClass('txop-noblock');
    } else {
      jQuery('body').removeClass('txop-noblock');
    }
  },

  componentDidMount(){
    this.setBodyClass();
  },

  componentDidUpdate(){
    this.setBodyClass();
  },

  sortableOptions: {
    ref: "sections"
  },

  handleEnd(e) {
    if (e.oldIndex === undefined || e.newIndex === undefined) {
      return;
    }

    let sections = _.copy(this.props.sections);
    sections     = _.move(sections, e.oldIndex, e.newIndex);

    sections[e.oldIndex].key = _.randomId('s_');
    sections[e.newIndex].key = _.randomId('s_');

    AppStore.reorder(sections, e.newIndex);
  },

  updateSection(index, section){
    AppActions.updateSection(index, section);
  },

  showBlocks(){
    this.setState({showBlocks: true});
  },

  closeBlocks(){
    this.setState({showBlocks: false});
  },

  render() {
    let sections = this.props.sections;
    let blocks   = this.props.blocks;

    let blocksClass = cx("list-blocks", {
      "hidden" : !this.state.showBlocks
    });

    let sectionsClass = cx("list-sections", {
      "hidden" : this.state.showBlocks
    });

    return (
      <div>
        <div className={sectionsClass}>
          <Button bsStyle='primary' className="btn-block" onClick={this.showBlocks}>
            <span className="fa fa-plus"></span> Add Block
          </Button>

          <div ref="sections">
            {sections.map((section, index)=> {
              return (
                <SectionLi
                  active={this.props.activeSectionIndex === index}
                  id={section.id}
                  title={section.title}
                  key={section.key}
                  index={index}/>
              );
            })}
          </div>
          <Footer />
        </div>

        <div className={blocksClass}>
          <BlockCollection closeBlocks={this.closeBlocks} blocks={blocks}/>
        </div>


      </div>
    ); //end jsx
  } //end render
});

module.exports = SectionList;
