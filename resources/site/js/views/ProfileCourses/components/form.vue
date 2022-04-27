<template>
  <section>
      <el-form ref="form" :model="form" class="mb-4 mt-4">
      <div class="row align-items-end" >
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
          <el-form-item :error="errors.get('edu_level_id')" class="col-md-4" label="Возраст" v-if="form.edu_type_id === 4">
              <el-select v-model="form.edu_level_id" placeholder="Возраст" style="width: 100%;">
                  <el-option
                      v-for="item in edu_levels"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id">
                  </el-option>
              </el-select>
          </el-form-item>
          <el-form-item label="Направление"  class="col-md-6 col-xl-4"  v-if="form.edu_type_id === 2 ||form.edu_type_id === 3 || form.edu_type_id === 4">
              <el-select v-model="form.direction_id"  placeholder="Выберите направление"
                         @change="selectDirection(form.direction_id)"
                         style="width: 100%;">
                  <el-option
                      v-for="item in directions"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id">
                  </el-option>
              </el-select>
          </el-form-item>
          <el-form-item :label="specialty"  class="col-md-6 col-xl-4"  v-if="form.edu_type_id === 2 || form.edu_type_id === 3 || form.edu_type_id === 4 ">
              <el-select v-model="form.specialty_id"  :placeholder="'Выберите ' + (form.edu_type_id === 4 ? 'программу' :  'специальность')" style="width: 100%;">
                  <el-option
                      v-for="item in specialties"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id">
                  </el-option>
              </el-select>
          </el-form-item>
          <el-form-item :error="errors.get('subject_id')" class="col-md-4" label="Предмет" v-if="form.edu_type_id !== 4">
              <el-select v-model="form.subject_id"
                         filterable placeholder="Выберите предмет"
                         style="width: 100%;"
                         @change="selectSubject"
              >
                  <el-option
                      v-for="item in subjects"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id">
                  </el-option>
              </el-select>
          </el-form-item>
          <el-form-item :error="errors.get('edu_level_id')" class="col-md-4" label="Год обучения" v-if="form.edu_type_id !== 4">
              <el-select v-model="form.edu_level_id" placeholder="Год обучения" style="width: 100%;">
                  <el-option
                      v-for="item in edu_levels"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id">
                  </el-option>
              </el-select>
          </el-form-item>
          <el-form-item class="col-md-12 col-xl-6 " v-if="themes_loaded && form.edu_type_id !== 4">
                    <div>
                        <label style="text-align: left" class="el-form-item__label">Ключевые фразы темы</label>
                        <el-tooltip class="item" effect="dark" content=" это слова или словосочетания, которые помогают при поиске темы" placement="top-start">
                            <svg class="course-item__author-icon">
                                <use xlink:href="/assets/site/images/sprites.svg?ver=12#sprite-question-icon"></use>
                            </svg>
                        </el-tooltip>
                    </div>
                  <el-select v-model="form.themes"
                             filterable
                             allow-create
                             default-first-option
                             multiple
                             placeholder="Выберите или добавьте свои темы курса" style="width: 100%;">
                      <el-option
                          v-for="item in themes"
                          :key="item.id"
                          :label="item.title"
                          :value="item.id">
                      </el-option>
                  </el-select>



          </el-form-item>
          <el-form-item class="col-md-6 col-xl-6" v-if="form.edu_type_id === 1">
              <el-checkbox border v-model="form.yege">Это подготовка к ЕГЭ</el-checkbox>
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
      computed: {
        specialty() {
            return this.form.edu_type_id === 4 ? 'Программа' : 'Специальность'
        }
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
        themes: [],
        specialties: [],
        directions:[],
          themes_loaded:false,
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
            this.$root.isLoading = false;
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
          let request = {};
          if(this.form.edu_type_id === 2 || this.form.edu_type_id === 3 || this.form.edu_type_id === 4) {
              request = {edu_type_id:this.form.edu_type_id}
          }
          axios.get(url, {params:request})
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
                if(type === 'theme') {
                    this.themes = response.data;
                    this.themes_loaded = true;
                }
                if(type === 'specialty' && parent_id) {
                    this.specialties = response.data;
                }
                if(type === 'specialty' && !parent_id) {
                    this.directions = response.data
                }
            })
        },
        selectEduType(id) {
           this.getCategories('edu_level', id);
           this.form.yege = false;
            this.form.direction_id = null;
            this.form.specialty_id = null;
           if(id === 2 || id === 3 || id === 4) {
               this.getCategories('specialty');
           }
        },
        selectSubject(id) {
            this.getCategories('theme');
        },
        selectDirection(id) {
            this.form.specialty_id = null;
            this.getCategories('specialty', id);
        }
    },
      mounted() {
        this.getCategories('edu_type');
        this.getCategories('subject');
        if(this.form.edu_type_id) {
            this.getCategories('edu_level', this.form.edu_type_id);
            if(this.form.edu_type_id === 2 || this.form.edu_type_id === 3) {
                this.getCategories('specialty');
            }
        }
        if(this.form.direction_id) {
            this.getCategories('specialty', this.form.direction_id);
        }
          this.getCategories('theme');
      }
  }
</script>
