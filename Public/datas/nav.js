var navs = [

	{
		"title": "首页",
		"icon": "fa fa-home fa-lg",
		"href": "/Home/Index/main",
		"spread": false
	},
        
        
  {
	"title": "角色管理",
	"icon": "&#xe613;",
	"spread": true,
	"children": [
		{
			"title": "添加管理员",
			"href": "/Home/User/add_admin"
		},

		{
		    "title": "管理员列表",
		    "href": "/Home/User/list_admin"
	    },
                              
	    {
		    "title": "修改密码",
		    "href": "/Home/User/alter_psd"
	    }

		]
   },
              



	{
	"title": "招聘管理",
	"icon": "fa fa-user-plus fa-lg",
	"spread": true,
	"children": [
		{
			"title": "部门及岗位管理",
			"href": "/Home/Index/section_manage"
		},

		{
		    "title": "招聘需求",
		    "href": "/Home/Index/recruit"
	    },

		{
		    "title": "人才库",
		    "href": "/Home/Index/talents"
	    },

		{
		"title": "面试管理",
		"href": "/Home/Index/interview"
	   }]
                 }

];