<template>
    <div class="card" style="margin: 0rem">
        <header class="card-header">
            <!--<p class="card-header-title">-->
                <!--Component-->
            <!--</p>-->
            <!--<a href="#" class="card-header-icon" aria-label="more options">-->
              <!--<span class="icon">-->
                <!--<i class="fa fa-angle-down" aria-hidden="true"></i>-->
              <!--</span>-->
            <!--</a>-->
            <a class="card-footer-item"  @click="addcurr">新增选课组</a>
            <!--<a class="card-footer-item">Edit</a>-->
            <a class="card-footer-item" @click="canContinue">选课完成</a>
        </header>
        <div class="card-content">
            <div class="content">
                <!--Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.-->
                <!--<a href="#">@bulmaio</a>. <a href="#">#css</a> <a href="#">#responsive</a>-->
                <!--<br>-->
                <!--<time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>-->

                <table class="bg-white" style="background-color: white" id="my-node">
                    <tr>
                        <th width="13%">日期</th>
                        <th width="70%">内容</th>
                        <th width="17%">建议时长</th>
                    </tr>
                    <tr  v-for=" curr in currSelected" >
                        <td><input type="date" placeholder="日期" class="input" v-model="curr.opdata"></td>
                        <td><span v-for="item in curr.currlist">{{item}}</span> </td>
                        <td><input type="text" placeholder="建议时间" class="input" v-model="curr.protime"></td>
                    </tr>
                </table>

                <div class="tree3"> <v-select-tree ref='tree3' :data='treeData3' v-model='initSelected' :multiple="true"/></div>

            </div>

        </div>
        <!--<footer class="card-footer">-->
            <!--<a class="card-footer-item">新增选课组</a>-->
            <!--&lt;!&ndash;<a class="card-footer-item">Edit</a>&ndash;&gt;-->
            <!--<a class="card-footer-item" @click="canContinue">选课完成</a>-->
        <!--</footer>-->
        <div style="background-color: #ddd;height: 50px;color: red;text-align: center;margin: 0 auto;
width: 100px;line-height:50px;
position: fixed;
bottom: 10px;right: 10px;border-radius:55px;">已选{{sum}}分</div>
    </div>

</template>

<script>
//    import 'vue-tree-halower/dist/halower-tree.min.css' // 你可以自定义树的样式
////    import VTree from 'vue-tree-halower'
//    import {VTree, VSelectTree} from 'vue-tree-halower'

//    Vue.use(VTree)
    export default {
        props: ['currentStep'],
        data () {
            return {
                lang: 'zh',
                searchword: '',
                recdata:sessionStorage.getItem('recdata'),
                currSelected: [],
                initSelected: [],
                treeData3: JSON.parse(sessionStorage.getItem('currdata')),
                datatimejson: JSON.parse(sessionStorage.getItem('datatimejson')),
                sum:0
            }
        },
        methods: {

            addcurr(){
//                alert(1);
                var nowarr = JSON.parse(JSON.stringify(this.initSelected));
                console.log('nowarr',nowarr);
                var opdata = new Date(this.recdata);
                //todo 根据选课计算视频时间
                var fenzhong = this.sum;
                var timetxt = fenzhong+'分钟';//fenzhong>60?parseInt(fenzhong/60)+'小时'+;
                var nowjson = {'opdata':this.recdata,'currlist':nowarr,'protime':timetxt};
                opdata = new Date(opdata.setDate(opdata.getDate()+1));
                console.log('opdata',opdata);
                var opmonth=(opdata.getMonth() + 1)<=9?'0'+(opdata.getMonth() + 1).toString():(opdata.getMonth() + 1);
                console.log('opmonth',opmonth);
                var opdatastr = opdata.getFullYear()+"-"+opmonth+"-"+opdata.getDate();
                console.log('opdatastr',opdatastr);
                this.recdata=opdatastr;
                this.currSelected.push(nowjson);
//                this.initSelected=[];
//                var _this=this;
//                _this.initSelected.forEach(function (item,index) {
//                    console.log(item,index);
////                      _this.initSelected.splice(index,1);
////                    _this.$refs.v-select-tree.initSelected.splice(index,1);
////                    _this.$refs.tree3.delNode(item,'',index)
////                            return true;
//                        });
            },
          canContinue() {
                console.log('recdata currSelected',sessionStorage.getItem('recdata'));
              sessionStorage.setItem('currSelected', JSON.stringify(this.currSelected));
//              this.$emit('setcurrlist', {value: this.currSelected});
              this.$emit('can-continue', {value: true});
          },
            nodechecked (node, v) {
                alert('that a node-check envent ...' + node.title + v)
            },
            // tpl (node, ctx, parent, index, props) {
            tpl (...args) {
                let {0: node, 2: parent, 3: index} = args
                let titleClass = node.selected ? 'node-title node-selected' : 'node-title'
                if (node.searched) titleClass += ' node-searched'
                return <span>
                <button class="treebtn1" onClick={() => this.$refs.tree1.addNode(node, {title: 'sync node'})}>+</button>
                <span class={titleClass} domPropsInnerHTML={node.title} onClick={() => {
                    this.$refs.tree1.nodeSelected(node)
                }}></span>
                <button class="treebtn2" onClick={() => this.asyncLoad1(node)}>async</button>
                <button class="treebtn3" onClick={() => this.$refs.tree1.delNode(node, parent, index)}>delete</button>
                </span>
            },
            async asyncLoad1 (node) {
                const {checked = false} = node
                this.$set(node, 'loading', true)
                let pro = new Promise(resolve => {
                    setTimeout(resolve, 2000, ['async node1', 'async node2'])
                })
                this.$refs.tree1.addNodes(node, await pro)
                this.$set(node, 'loading', false)
                if (checked) {
                    this.$refs.tree1.childCheckedHandle(node, checked)
                }
            },
            async asyncLoad2 (node) {
                const {checked = false} = node
                this.$set(node, 'loading', true)
                let pro = await new Promise(resolve => {
                    setTimeout(resolve, 2000, [{title: 'test1', async: true}, {title: 'test2', async: true}, {title: 'test3'}])
                })
                if (!node.hasOwnProperty('children')) {
                    this.$set(node, 'children', [])
                }
                node.children.push(...pro)
                this.$set(node, 'loading', false)
                if (checked) {
                    this.$refs.tree2.childCheckedHandle(node, checked)
                }
            },
            search () {
                this.$refs.tree3.searchNodes(this.searchword)
            }
        },
        watch:{
            initSelected(val){
                console.log('initSelected',val,JSON.stringify(val));
                var sum = 0;
                for(var i=0;i<val.length;i++){
                    if(this.datatimejson.hasOwnProperty(val[i])){
                        console.log(val[i],this.datatimejson[val[i]]);//[val[i]].time
                        sum = sum+parseInt(this.datatimejson[val[i]]);
                    }

                }
                console.log('sum',sum);
                this.sum = sum;
            }
        },
        mounted() {
//            this.$emit('can-continue', {value: true})
            Date.prototype.Format = function (fmt) {
                var o = {
                    "M+": this.getMonth() + 1, //月份
                    "d+": this.getDate(), //日
                    "h+": this.getHours(), //小时
                    "m+": this.getMinutes(), //分
                    "s+": this.getSeconds(), //秒
                    "q+": Math.floor((this.getMonth() + 3) / 3), //季度
                    "S": this.getMilliseconds() //毫秒
                };
                if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
                for (var k in o)
                    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
                return fmt;
            }
        }
    }
</script>


<style>
    .tree3{
        /*float: left;*/
        /*width: 33%;*/
        padding: 10px;
        box-sizing: border-box;
        border: 1px dotted #ccccdd;
        overflow: auto;
        height: 800px;
    }
    .treebtn1{
        background-color: transparent;
        border: 1px solid #ccc;
        padding: 1px 3px;
        border-radius: 5px;
        margin-right: 5px;
        color: rgb(148, 147, 147);
    }
    .treebtn2{
        background-color: transparent;
        border: 1px solid #ccc;
        padding: 3px 5px;
        border-radius: 5px;
        margin-left: 5px;
        color: rgb(97, 97, 97);
    }
    .treebtn3{
        background-color: transparent;
        border: 1px solid #ccc;
        padding: 3px 5px;
        border-radius: 5px;
        margin-left: 5px;
        color: rgb(63, 63, 63);
    }
    .tree-search-input{
        width: 70%;
        padding: 6px 8px;
        outline: none;
        border-radius: 6px;
        border:1px solid #ccc;
    }
    .tree-search-btn{
        width: 25%;
        padding: 6px 8px;
        outline: none;
        border-radius: 6px;
        background-color: rgb(218, 218, 218);
        border:1px solid rgb(226, 225, 225);
        color: rgb(117, 117, 117);
    }

    .tree-container1 {
        position: relative;
        width: 90%;
        height: 36px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
</style>