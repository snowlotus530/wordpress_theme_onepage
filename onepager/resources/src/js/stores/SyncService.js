const $               = jQuery; //jshint ignore: line
const SectionComputer = require('../lib/SectionComputer');
const notify          = require('../lib/notify');
const ODataStore      = require('./ODataStore');
const AppActions      = require('../actions/AppActions');
const async           = require('async');
//const _               = require('underscore');

require('../lib/_mixins');

function SyncService(pageId, inactive, shouldSectionsSync){

  let updateSection = function(sections, sectionIndex){
    let payload = {
      pageId  : pageId,
      action  : 'save_sections',
      updated : sectionIndex,
      sections: SectionComputer.simplifySections(sections),
    };

    let sync = function(){
      $.post(ODataStore.ajaxUrl, payload, (res)=>{
        if(!res || !res.success){
          return notify.warning('Failed to update :(');
        }

        //else
        AppActions.sectionSynced(sectionIndex, res);
        return notify.success('Successfully Updated Sections');
      });
    };

    async.series([
      (pass)=> inactive().then(pass),
      (pass)=> shouldSectionsSync(sections).then(pass),
      (pass)=> sync(pass)
    ]);
  };

  let rawUpdate = function(sections){
    let payload = {
      pageId  : pageId,
      action  : 'save_sections',
      updated : null,
      sections: SectionComputer.simplifySections(sections),
    };

    let sync = function(){
      $.post(ODataStore.ajaxUrl, payload, (res)=>{
        if(!res || !res.success){
          return notify.warning('Failed to update');
        }

        return notify.success('Successfully Updated');
      });
    };

    async.series([
      (pass)=> inactive().then(pass),
      (pass)=> shouldSectionsSync(sections).then(pass),
      (pass)=> sync(pass)
    ]);
  };

  return {
    updateSection,
    rawUpdate
  };
}


module.exports = SyncService;
