/*
 * elastic-datatables
 * https://github.com/pidupuis/elastic-datatables
 *
 * Copyright (c) 2015 pidupuis
 * Licensed under the MIT license.
 */

(function($) {
	function toTitleCase(str) {
	  return str.replace(
	    /\w\S*/g,
	    function(txt) {
	      return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
	    }
	  );
	}

	function extract(key,maps,mapping){
		for(hit in maps){
			var hit_item = maps[hit];
			var title = key+hit;
			if('properties' in hit_item){
				extract(title+'.',hit_item['properties'],mapping);
			} else {
				item = {
					sTitle:toTitleCase(title.replace("_"," ").replace("."," - ")),
					sName:title,
					type:hit_item['type']
				}
				if(hit_item['type'] == 'text'){
					item = {
						sTitle:toTitleCase(title.replace("_"," ").replace("."," - ")),
						sName:title,
						orderable:false,
						type:hit_item['type']
					}
				}
				mapping.push(item);
			}
		}
	}

	$.fn.dataTable.elastic_datatables = function(opts) {
		// CONFIGURATION OPTIONS
		var conf = $.extend({
			index: '',
			type: '',
			client: elasticsearch.Client({ // Default elasticsearch instance
				host: 'localhost:9200'
			}),
			body: '',
			columnsList: []
		}, opts);

		return function(sSource, aoData, fnCallback) {
			// EXTRACT DATATABLE STATE
			var draw = aoData.filter(function(obj) {
				return obj.name === 'draw';
			})[0].value;
			var columns = aoData.filter(function(obj) {
				return obj.name === 'columns';
			})[0].value;
			var order = aoData.filter(function(obj) {
				return obj.name === 'order';
			})[0].value;
			var start = aoData.filter(function(obj) {
				return obj.name === 'start';
			})[0].value;
			var length = aoData.filter(function(obj) {
				return obj.name === 'length';
			})[0].value;
			var search = aoData.filter(function(obj) { // TODO: find a way to use search param to filter results
				return obj.name === 'search';
			})[0].value;
			//SORTING PARAMETERS
			var sort = [];
			order.forEach(function(c) {
				if(columns[c.column].orderable){
					var colSort = {};
					colSort[columns[c.column].name] =  c.dir
					sort.push(colSort);	
				}
			});
			if(sort.length > 0){
				conf.body.sort = sort;
			}
			console.log(conf.body);
			console.log("-----------------");
			// ELASTICSEARCH QUERY
			conf.client.search({
				'index': conf.index,
				'type': conf.type,
				'from': start,
				'size': length,
				'body': conf.body,
				//'sort': sort
			}, function(error, response) {
				var length = response.hits.total.value;
				var dataSet = [];
				response.hits.hits.forEach(function(hit) {
					var row = [];
					columns.forEach(function(col) {
						var split_col = col.name.split(".");
						var item = hit._source;
						for(var i = 0; i<split_col.length; i++){							
							if(item[split_col[i]]){
								item = item[split_col[i]];
								////Transform Function///
								var columnData = conf.columnsList[col.data];
								if(columnData){
									//// Transform Date Type/////
									if(columnData.type == 'date'){
										item = new Date(item).toISOString().substring(0, 10)+' '+ new Date(item).toLocaleTimeString();	
									}
								}
							}
							else{ 
								item = '-';
							}
						}
						row.push(item);
					});
					dataSet.push(row);
				});

				// RETURN RESULTS
				fnCallback({
					'draw': draw,
					'recordsTotal': length,
					'recordsFiltered': length, // TODO: Adapt this number once the search param is used
					'data': dataSet
				});
			});
		};
	};

	$.fn.dataTable.getMapping = function(opts,result) {
		var conf = $.extend({
			index: '',
			execpt:[],
			client: elasticsearch.Client({ // Default elasticsearch instance
				host: 'localhost:9200'
			}),
		}, opts);
		conf.client.indices.getMapping({
			'index': conf.index
		}, function(error, response) {
			var maps = response[conf.index]['mappings']['properties'];
			let mapping = [];
			for(hit in maps){
				var hit_item = maps[hit];
				if(conf.execpt.includes(hit)){
					continue;
				} else if('properties' in hit_item){
					extract(hit+'.',hit_item['properties'],mapping)
				} else {
					var item = {
						sTitle:toTitleCase(hit.replaceAll("_"," ")),
						sName:hit,
						type:hit_item['type']
					}
					if(hit_item['type'] == 'text'){
						var item = {
							sTitle:toTitleCase(hit.replaceAll("_"," ")),
							sName:hit,
							orderable:false,
							type:hit_item['type']
						}
					}
					mapping.push(item);
				}
			}
			result(mapping);
		});	
	};

}(jQuery));
