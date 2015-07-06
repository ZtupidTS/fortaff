function trim(s)
{
    return rtrim(ltrim(s));
}
function rtrim(s)
{
    var r=s.length -1;
    while(r > 0 && s[r] == ' ')
    {   r-=1;   }
    return s.substring(0, r+1);
 }
 function ltrim(s)
{
    var l=0;
    while(l < s.length && s[l] == ' ')
    {   l++; }
    return s.substring(l, s.length);
}
function trimStr(str) {
  return str.replace(/^\s+|\s+$/g, '');
}