<?php
    /**
    * @author: AMEZGHAL abdelilah <amezghal@msn.com>
    */
    class Indenter {
    public function __construct(){
    }
    private $is_string1 = false;
    private $is_string2 = false;
    private $is_comment1 = false;
    private $is_comment2 = false;
    public function valid(){
    return (
    $this->is_string1 == false && $this->is_string2 == false &&
    $this->is_comment1 == false && $this->is_comment2 == false
    );
    }
    public function indent($content){
    $string=trim($content);
    if(substr($string,0,5)=='<?php'){
    $string=substr($string,5,strlen($string)-7);
    }else{
    $string=substr($string,2,strlen($string)-4);
    }
    $out = "<?php\n";
    $arc = 0;
    $semilicon = false;
    $space = true;
    $tab='';
    $is_condition = false;
    $update=true;
    for($i = 0; $i < strlen( $string ); $i++) {
    $char = substr($string, $i, 1);
    switch($char) {
    case '"':
    if($this->is_comment1 == false && $this->is_comment2 == false) {
    if($this->is_string1) {
    if(substr($string,$i-1,1)!='\\') {
    $this->is_string1=false;
    }
    }else{
    if($this->is_string2==false){
    $this->is_string1=true;
    }
    }
    }
    $out .= $char;
    break;
    case '\'':
    if($this->is_comment1 == false && $this->is_comment2 == false) {
    if($this->is_string2) {
    if(substr($string,$i-1,1)!='\\'){
    $this->is_string2=false;
    }
    }else{
    if($this->is_string1==false){
    $this->is_string2=true;
    }
    }
    }
    $out .= $char;
    break;
    case '/':
    if($this->is_string1 == false && $this->is_string2 == false) {
    if(substr($string, $i-1, 1)=='/'){
    $this->is_comment1=true;
    $semilicon=false;
    }
    if($this->is_comment2){
    if(substr($string, $i-1, 1)=='*'){
    $this->is_comment2=false;
    $out .= $char."\n".$tab;
    $update=false;
    }
    }
    }
    if($update) {
    $out .= $char;
    }else{
    $update = true;
    }
    break;
    case '*':
    if($this->valid()) {
    if(substr($string,$i-1,1)=='/'){
    $this->is_comment2=true;
    $out = substr($out,0,strlen($out)-1);
    $out .=$tab.'/*';
    }
    }else{
    $out .= $char;
    }
    break;
    case '(':
    if($this->valid()) {
    $arc++;
    if($is_condition==false) {
    $is_condition=true;
    }
    }
    $out .= $char;
    break;
    case ')':
    if($this->valid()) {
    $arc--;
    if($arc==0){
    $is_condition=false;
    }
    }
    $out .= $char;
    break;
    case ';':
    if($this->valid()) {
    if($is_condition){
    $out .= $char.' ';
    $space = false;
    }else{
    $semilicon = true;
    $out .= $char;
    }
    }else{
    $out .= $char;
    }
    break;
    case '{':
    if($this->valid()) {
    $out .= "\n" . $tab . $char . "\n";
    $tab .= "\t";
    $out .= $tab;
    }else{
    $out .= $char;
    }
    break;
    case '}':
    if($this->valid()) {
    $tab = substr($tab, 0, strlen($tab)-1);
    $out .="\n".$tab.$char."\n";
    }else{
    $out .= $char;
    }
    break;
    case ':':
    if($this->valid()) {
    $out .= $char."\n".$tab;
    }
    break;
    case "\n":
    if($this->is_comment1){
    $out .= $char.$tab;;
    $this->is_comment1=false;
    }elseif($this->is_comment2){
    $out .= $char.$tab;
    }
    break;
    case "\r":
    case "\t":
	if($this->is_string1==true || $this->is_string2==true) {
    $out .= $char;
    }
    break;
    case ' ':
    if($this->valid()) {
    if($space) {
    $out .= $char;
    $space = false;
    }
    }else{
    $out .= $char;
    }
    break;
    default:
    $space=true;
    if($semilicon) {
    $out .= "\n".$tab.$char;
    $semilicon = false;
    } else {
    $out .= $char;
    }
    }
    }
    $out."\n?>";
    return $out;
    }
    }
?>