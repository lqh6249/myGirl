define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'article/mood/index',  
                    add_url: 'article/mood/add',
                    edit_url: 'article/mood/edit',
                    del_url: 'article/mood/del',
                    multi_url: 'article/mood/multi',
                    dragsort_url: '',
                    table: 'article_mood',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                escape: false,
                pk: 'id',
                sortName: 'id',
                pagination: true,
                commonSearch: false,
                columns: [
                    [
                        {field: 'state', checkbox: true},
                        {field: 'id', title: 'ID'},
                        {field: 'content', title: '语录', formatter: Table.api.formatter.title, operate: false},
						{field: 'views', title: '浏览次数', operate: false},
                        {field: 'comments', title: '评论数', operate: false},
                        {field: 'status', title: '状态', operate: false, formatter: Table.api.formatter.status},
						{field: 'create_time', title: '添加时间', formatter: Table.api.formatter.datetime, operate: 'BETWEEN', type: 'datetime', addclass: 'datetimepicker', data: 'data-date-format="YYYY-MM-DD"'},
                        {field: 'operate', title: '操作', table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {          
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});