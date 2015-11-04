var path = $('#filePath').text();
/* OpenDir */
function openDir(path) {
	$.webmis.win('close','SysFilemanager?path='+path);
}
/* UpLevel */
function backDir(path) {
	$.webmis.win('close','SysFilemanager?path='+path);
}
/* Refresh */
function refreshDir(path) {
	$.webmis.win('close','SysFilemanager?path='+path);
}