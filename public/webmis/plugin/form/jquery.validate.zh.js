/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: ZH (Chinese, 中文 (Zhōngwén), 汉语, 漢語)
 */
$.extend( $.validator.messages, {
	required: "<em></em>必填",
	remote: "<em></em>错误",
	email: "<em></em>请输入邮件地址",
	url: "<em></em>请输入网址",
	date: "<em></em>请输入日期",
	dateISO: "<em></em>请输入日期 (YYYY-MM-DD)",
	number: "<em></em>请输入数字",
	digits: "<em></em>只能数字",
	creditcard: "<em></em>请输入信用卡号码",
	equalTo: "<em></em>不一致",
	extension: "<em></em>请输入后缀",
	maxlength: $.validator.format( "<em></em>最多{0}位字符" ),
	minlength: $.validator.format( "<em></em>最少{0}位字符" ),
	rangelength: $.validator.format( "<em></em>请输入{0}~{1}位字符" ),
	range: $.validator.format( "<em></em>{0}~{1}的数值" ),
	max: $.validator.format( "<em></em>不大于{0}的数值" ),
	min: $.validator.format( "<em></em>不小于{0}的数值" )
} );