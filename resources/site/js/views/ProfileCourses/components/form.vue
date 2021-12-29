<template>
  <section>
      <el-form ref="form" :model="form" class="mb-4">
      <div class="mt-4 row">
          <el-form-item :error="errors.get('edu_type_id')" class="col-md-4" label="Тип образования">
              <el-select v-model="form.edu_type_id"
                         placeholder="Выберите тип образования"
                         style="width: 100%;"
                        @change="selectEduType"
              >
                  <el-option
                      v-for="item in edu_types"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id">
                  </el-option>
              </el-select>
          </el-form-item>
          <el-form-item :error="errors.get('subject_id')" class="col-md-4" label="Предмет">
              <el-select v-model="form.subject_id"
                         filterable placeholder="Выберите предмет"
                         style="width: 100%;"
              >
                  <el-option
                      v-for="item in subjects"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id">
                  </el-option>
              </el-select>
          </el-form-item>
          <el-form-item :error="errors.get('edu_level_id')" class="col-md-4" label="Уровень образования">
              <el-select v-model="form.edu_level_id" placeholder="Выберите уровень образования" style="width: 100%;">
                  <el-option
                      v-for="item in edu_levels"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id">
                  </el-option>
              </el-select>
          </el-form-item>
      </div>
        <el-form-item label="Название курса" :error="errors.get('title')">
          <el-input v-model="form.title"></el-input>
        </el-form-item>
      <el-row type="flex" class="align-items-center" :gutter="5">
        <el-col :span="6">
          <el-form-item prop="preview" label="Изображение обложки" style="margin-bottom: 2rem">
            <el-upload
                action=""
                v-model="form.image"
                class="avatar-uploader"
                :auto-upload="false"
                :show-file-list="false"
                :on-change="uploadImage"
            >
              <img v-if="form.image" :src="form.image" class="avatar">
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
          </el-form-item>
        </el-col>
        <el-col :span="18">
          <el-form-item label="Краткое описание курса для анонса" prop="description">
            <div>
              <textarea style="width:100%"   v-model="form.description" ></textarea>
            </div>
          </el-form-item>
        </el-col>
      </el-row>
      <el-button  type="primary" @click.prevent="storeCourse()"  style="text-transform: uppercase">Сохранить курс</el-button>
          <el-button  type="default" @click.prevent="closeCourse()"  style="text-transform: uppercase">Вернуться к списку курсов</el-button>
    </el-form>
  </section>
</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
  export default {
    components:{
    },
    props:{

      actionUrl: {
        type:String,
        required:true,
      },
      form: {
        type:Object,
        required:true,
      }
    },
    data() {
      return {
        edu_types: [],
        subjects:[],
        edu_levels:[],
        errors: new Errors(),
      }
    },
    methods: {
        closeCourse(){
            window.location.href='/profile/my-courses/active';
        },
      storeCourse() {
            this.$root.isLoading =  true;
        axios.post(this.actionUrl, this.form)
        .then((response) => {
            this.$root.isLoading = false;
            window.location.href = response.data;
        })
        .catch((error) => {
          this.errors.record(error.response.data.errors);
        })
      },
      uploadImage(file){
        let cond = this.beforeImageUpload(file.raw);
        console.log(cond);
          this.form['imageName'] = file.raw.name;
        if(cond){
          this.createImage(file);
        }
      },
      beforeImageUpload(file) {
        const isJPG = file.type === 'image/jpeg';
        const isPNG = file.type === 'image/png';
        const isLt2M = file.size / 1024 / 1024 < 2;
        if (!isJPG && !isPNG) {
          this.$message.error('Картинка должна быть в формате jpeg или png');
        }
        if (!isLt2M) {
          this.$message.error('Размер не может превышать 2МБ');
        }
        return (isJPG || isPNG) && isLt2M;
      },
      createImage(file) {
        let reader = new FileReader();
        let vm = this;
        reader.onload = (e) => {
          vm.form.image = e.target.result;
        };
        reader.readAsDataURL(file.raw);
      },
        getCategories(type, parent_id = null) {
          let url = '/api/category/list/' + type;
          if(parent_id) {
              url = url + '/' + parent_id;
          }
          axios.get(url)
            .then((response) => {
                if(type === 'edu_type') {
                    this.edu_types = response.data;
                }
                if(type === 'subject') {
                    this.subjects = response.data;
                }
                if(type === 'edu_level') {
                    this.edu_levels = response.data;
                }
            })
        },
        selectEduType(id) {
           this.getCategories('edu_level', id);
        }
    },
      mounted() {
        this.getCategories('edu_type');
        this.getCategories('subject');
        if(this.form.edu_type_id) {
            this.getCategories('edu_level', this.form.edu_type_id);
            console.log(this.form.edu_type_id);
        }
      }
  }
</script>
