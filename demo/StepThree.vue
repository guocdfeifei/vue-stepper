<template>
    <div class="card" style="margin: 3rem">
        <header class="card-header">
            <!--<p class="card-header-title">-->
                <!--Component-->
            <!--</p>-->
            <!--<a href="#" class="card-header-icon" aria-label="more options">-->
              <!--<span class="icon">-->
                <!--<i class="fa fa-angle-down" aria-hidden="true"></i>-->
              <!--</span>-->
            <!--</a>-->
            <!--<a class="card-footer-item"  @click="addcurr">新增选课组</a>-->
            <!--<a class="card-footer-item">Edit</a>-->
            <a class="card-footer-item" @click="canContinue">生成学习计划</a>
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
                        <td>{{curr.opdata | formatdata}}</td>
                        <td><span v-for="item in curr.currlist">{{item}}</span> </td>
                        <td>{{curr.protime}}</td>
                    </tr>
                </table>

                <!--<div v-for=" curr in currSelected"  calss="tree-container1">-->
                    <!--<div  class="tag-box-container">-->
                        <!--<div class="tag-box" style="transition: transform 0.4s ease 0s; transform: translateX(0px);">-->

                            <!--<div class="tag" v-for="item in curr">-->
                                <!--{{ item }}-->
                                <!--&lt;!&ndash;<span class="rmNode">x</span>&ndash;&gt;-->
                            <!--</div>-->

                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
                <!--<span>建议时长</span>-->

                <!--<div class="tree3"> <v-select-tree ref='tree3' :data='treeData3' v-model='initSelected' :multiple="true"/></div>-->
            </div>

        </div>
        <!--<footer class="card-footer">-->
            <!--<a class="card-footer-item">新增选课组</a>-->
            <!--&lt;!&ndash;<a class="card-footer-item">Edit</a>&ndash;&gt;-->
            <!--<a class="card-footer-item" @click="canContinue">选课完成</a>-->
        <!--</footer>-->
        <img  :src="imgsrc" >
    </div>
</template>

<script>
//    import 'vue-tree-halower/dist/halower-tree.min.css' // 你可以自定义树的样式
////    import VTree from 'vue-tree-halower'
//    import {VTree, VSelectTree} from 'vue-tree-halower'
import domtoimage from 'dom-to-image';
//    Vue.use(VTree)
    export default {
        props: ['currentStep'],
        data () {
            return {
                lang: 'zh',
                searchword: '',
                imgsrc:'',
                currSelected: JSON.parse(sessionStorage.getItem('currSelected')),
                initSelected: [],
                treeData3: [{
                    title: '必修',
                    expanded: true,
                    children: [{
                        title: '集合+函数+基础初等函数',
                        expanded: true,
                        children: [{
                            title: '1.1.1-1集合的含义与表示--集合的含义和特征'
                        }, {
                            title: '1.1.1-2元素与集合的关系'
                        }, {
                            title: '1.1.1-3集合的表示方法'
                        }]
                    },{
                        title: '立体几何+直线和圆',
                        expanded: true,
                        children: [{
                            title: '1.1-1空间几何体---概念'
                        }, {
                            title: '1.1-2基础练习题'
                        }]
                    }]
                },{
                    title: '选修',
                    expanded: true,
                    children: [{
                        title: '统计案例',
                        expanded: true,
                        children: [{
                            title: '1.1回归分析'
                        }, {
                            title: '1.2独立性检验'
                        }]
                    },{
                        title: '推理与证明',
                        expanded: true,
                        children: [{
                            title: '2.1合情推理与演绎推理'
                        }, {
                            title: '2.2直接证明与间接证明'
                        }]
                    }]
                }]
            }
        },
        filters: {
            formatdata(value){

                return value.substr(5);
            },
        },
        methods: {

            addcurr(){
//                alert(1);
                var nowarr = JSON.parse(JSON.stringify(this.initSelected));
                console.log('nowarr',nowarr);
                this.currSelected.push(nowarr);
//                this.initSelected=[];
                var _this=this;
                _this.initSelected.forEach(function (item,index) {
                    console.log(item,index);
                      _this.initSelected.splice(index,1);
//                    _this.$refs.v-select-tree.initSelected.splice(index,1);
//                    _this.$refs.tree3.delNode(item,'',index)
//                            return true;
                        });
            },
          canContinue() {
              var node = document.getElementById('my-node');
              var _this=this;
              domtoimage.toPng(node)
                  .then(function (dataUrl) {
                      var img = new Image();
                      img.src = dataUrl;
                      console.log('dataUrl',dataUrl);
                      _this.imgsrc = dataUrl;
//                      document.body.appendChild(img);
                  })
                  .catch(function (error) {
                      console.error('oops, something went wrong!', error);
                  });
//              console.log('recdata 11currSelected',sessionStorage.getItem('recdata'),typeof(sessionStorage.getItem('currSelected')),typeor(this.currSelected));
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

        mounted() {
//            this.$emit('can-continue', {value: true})
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