<template>
  <nav class="filter-nav" v-click-outside="closeEvent">
    <ul class="filter-nav__list">
        <li class="filter-nav__item" v-for="(edu_type, index) in edu_types"

        >
          <a href="" class="filter-nav__link" @click.prevent="selectEdu(index)">
            {{edu_type.title}}
          </a>
          <div class="filter-nav__sub"
            :class="{
              'filter-nav__sub--open': (index === selectedEdu) && Eduselected === true
            }"

          >

            <div class="filter-nav__sub-inner">
              <section class="filter-nav__search">
                <div class="b-search">
                  <input class="b-search__input" type="text" v-model="search" name="query" placeholder="Поиск по предметам">
                  <button type="submit" class="b-search__btn"  @click.prevent="">
                    <svg class="b-search__icon">
                      <use xlink:href="/images/sprite.svg#search"></use>
                    </svg>
                  </button>
                </div>
              </section>
              <section class="filter-nav__filter" :style="{maxHeight: listHeight + 20 + 'px'}">
                <div class="filter-nav__levels">
                  <ul class="filter-nav-list" id="filter_nav_levels">
                    <li class="filter-nav-list__item "
                        v-for="(level, index) in levels"
                        @click.prevent="selectLevel(level, index)"
                        :class="{
                      'filter-nav-list__item--disabled':level.disabled,
                      'filter-nav-list__item--selected':index === level_selected,
                        }"
                    >
                      {{level.title}}
                    </li>
                  </ul>
                </div>
                <div class="filter-nav__subjects">
                  <ul class="filter-nav-list filter-nav-list--subjects" :style="{maxHeight: listHeight + 'px'}">
                    <li class="filter-nav-list__item "
                        @click.prevent="selectSubject(subject, index)"
                        :class="{
                      'filter-nav-list__item--disabled':subject.disabled,
                      'filter-nav-list__item--selected':index === subject_selected,
                        }"
                        v-for="(subject, index) in filteredSubjects"
                    >
                      {{subject.title}}
                    </li>
                  </ul>
                </div>
              </section>
            </div>

          </div>
        </li>
    </ul>
  </nav>
</template>
<script>
  export default {
    data() {
      return {
        listHeight:null,
        search: "",
        level_selected:null,
        subject_selected:null,
        Eduselected: false,
        edu_types: [],
        levels:[],
        subjects:[],
        selectedEdu:null,
      }
    },

    methods: {
      searchPage() {
        let data = {
          edu_type:this.edu_types[this.selectedEdu].slug,
          level:this.levels[ this.level_selected].id,
          subject:this.subjects[this.subject_selected].id
        };
        axios.post('/api/header-nav/filter', data)
        .then((response) => {
          console.log(response.data);
          location.href= response.data;
        })
      },
      selectSubject(subject, index) {
        this.subject_selected = index;
        if(this.level_selected !=null) {
          this.searchPage()
        } else {
          this.getLevels(this.edu_types[this.selectedEdu]['id'], this.subjects[index].id)
          this.level_selected = null;
        }
      },
      selectLevel(level, index) {
        this.level_selected = index;
        if(this.subject_selected !=null) {
          this.searchPage();
        } else {
          this.getSubjects(this.edu_types[this.selectedEdu]['id'], this.levels[index].id)
          this.subject_selected = null;
        }
      },
      getEduTypes() {
        axios.get('/api/header-nav/edu-types')
        .then((response) => {
          this.edu_types = response.data;
        })
      },
      getLevels(id, subject_id=null) {
        axios.get('/api/header-nav/edu-levels', {params: {id:id, subject_id:subject_id}})
            .then((response) => {
              this.levels = response.data;
            })
      },
      getSubjects(id, level_id=null) {
        axios.get('/api/header-nav/edu-subjects', {params:{id:id, level_id:level_id}})
            .then((response) => {

              this.subjects = response.data;
            })
      },
      selectEdu(index) {
        if(index === 0) {
          this.listHeight = 450
        } else if(index === 1) {
          this.listHeight =170
        } else {
          this.listHeight =210
        }
        if(index != 3) {
          this.Eduselected = true
          this.selectedEdu = index;
          this.getLevels(this.edu_types[index]['id']);
          this.getSubjects(this.edu_types[index]['id']);
        }
        this.level_selected =null;
        this.subject_selected=null;
      },
      closeEvent() {
        this.selectedEdu = false;
        }

    },
    directives: {
      'click-outside': {
        bind: function(el, binding, vNode) {
          // Provided expression must evaluate to a function.
          if (typeof binding.value !== 'function') {
            const compName = vNode.context.name
            let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`
            if (compName) { warn += `Found in component '${compName}'` }

            console.warn(warn)
          }
          // Define Handler and cache it on the element
          const bubble = binding.modifiers.bubble
          const handler = (e) => {
            if (bubble || (!el.contains(e.target) && el !== e.target)) {
              binding.value(e)
            }
          }
          el.__vueClickOutside__ = handler

          // add Event Listeners
          document.addEventListener('click', handler)
        },

        unbind: function(el, binding) {
          // Remove Event Listeners
          document.removeEventListener('click', el.__vueClickOutside__)
          el.__vueClickOutside__ = null

        }
      }
    },
    computed: {
      filteredSubjects() {
        return this.subjects.filter(subject => {
          return subject.title.toLowerCase().includes(this.search.toLowerCase())
        })
      }
    },

    mounted() {
      this.getEduTypes();


    }
  }
</script>
