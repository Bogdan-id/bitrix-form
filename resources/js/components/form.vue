<template>
  <v-row class="d-flex justify-center">
    <v-overlay :value="overlay">
      <v-progress-circular
        indeterminate
        size="64"
      ></v-progress-circular>
    </v-overlay>
    <v-col lg="10" md="12">
      <v-card class="pb-4">
        <v-card-title class="custom-title">
          Загальнi данi
        </v-card-title>
        <v-card-text class="pt-6">
          <v-text-field
            v-model="calcObj.project_name"
            label="Назва проекту (Лізингоодержувач)"
            dense readonly
            color="black">
          </v-text-field>
          <v-text-field
            v-model="calcObj.project_type"
            label="Тип проекту"
            dense readonly
            color="black">
          </v-text-field>
          <div> Фiнансування </div>
          <v-row class="mb-1 ml-1 mr-1">
            <v-col cols="12" md="4">
              <v-text-field
                v-model="calcObj.advance"
                label="Аванс, %"
                dense readonly
                color="black">
              </v-text-field>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field
                v-model="calcObj.leasing_term"
                label="Строк, міс."
                dense readonly
                color="black">
              </v-text-field>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field
                v-model="calcObj.amount_of_financing"
                id="amount_of_financing"
                label="Сума фін-ння, грн. (дол. США)"
                dense readonly
                color="black">
              </v-text-field>
            </v-col>
          </v-row>
          <v-text-field
            v-model="calcObj.leasing_object_name"
            label="Назва Об'єкту Лізингу (ОЛ)."
            dense readonly
            color="black">
          </v-text-field>
          <div> ОЛ (страхування) </div>
          <v-row class="mb-1 ml-1 mr-1">
            <v-col cols="12" md="4">
              <v-text-field
                v-model="calcObj.quantity"
                label="Кількість ОЛ"
                dense readonly
                color="black">
              </v-text-field>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field
                v-model="calcObj.insurance_program"
                label="Страхування (Стандарт /КАСКО Обережний)"
                dense readonly
                color="black">
              </v-text-field>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field
                v-model="calcObj.franchise"
                label="Франшиза, %"
                dense readonly
                color="black">
              </v-text-field>
            </v-col>
          </v-row>
          <v-textarea
            v-model="calcObj.non_standart_comment"
            label="У разі, якщо тип угоди Нестандарт, вказати в чому нестандарт і чим перекриті відхилення від стандарту "
            outlined dense
            color="black"
            rows="2">
          </v-textarea>
          <v-text-field
            v-model="calcObj.lead_source"
            label="Джерело надходження запиту"
            dense readonly
            color="black">
          </v-text-field>
          <v-text-field
            v-model="calcObj.agent_info"
            label="Розмір АВ, П.І.Б. агента, посада агента"
            dense readonly
            color="black">
          </v-text-field>
          <v-textarea
            v-model="calcObj.front_manager_comment"
            label="Коментар фронт-менеджера, щодо наявності АВ у випадку повторного звернення/ погодження керівника"
            outlined dense
            color="black"
            rows="2">
          </v-textarea>
        </v-card-text>

        <v-card-title class="custom-title">
          Схема роботи з постачальником
        </v-card-title>
        <v-card-text class="pt-6">
          <v-text-field
            v-model="calcObj.supplier_name"
            label="Назва Постачальника"
            dense readonly
            color="black">
          </v-text-field>
          <v-text-field
            v-model="calcObj.leasing_amount_dkp"
            label="Вартість ОЛ по прайсу (в валюті Постачальника)"
            dense readonly
            color="black">
          </v-text-field>
          <v-text-field
            v-model="calcObj.availability_leasing_object"
            label="Наявність ОЛ/ Строк поставки"
            dense
            color="black">
          </v-text-field>
          <div> Фiнансування </div>
          <v-row class="mb-1 ml-1 mr-1">
            <v-col cols="12" md="6">
              <v-text-field
                v-model="calcObj.supplier_prepayment"
                label="Передплата Постачальнику"
                dense
                color="black">
              </v-text-field>
            </v-col>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="calcObj.preliminary_financing"
                label="Попередня комісія"
                dense readonly
                color="black">
              </v-text-field>
            </v-col>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="calcObj.gps_tracker"
                label="Встановлення GPS"
                dense readonly
                color="black">
              </v-text-field>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-title id="contactPerson" class="custom-title">
          Контактна особа постачальника
        </v-card-title>
        <v-card-text class="pt-6" style="position: relative;">
          <v-overlay :value="contactPositionOverlay" absolute>
            <v-progress-circular
              indeterminate
              :size="24"
              :width="2"
            ></v-progress-circular>
          </v-overlay>
          <div v-if="calcObj.supplier_type && calcObj.supplier_type === 1">
            <v-text-field
              v-model="calcObj.contact_name"
              label="П.І.Б."
              dense readonly
              color="black">
            </v-text-field>
            <v-text-field
              v-model="calcObj.contact_position"
              label="Посада"
              dense readonly
              color="black">
            </v-text-field>
            <v-row>
              <v-col cols="12" md="5">
                <v-text-field
                  v-model="calcObj.contact_phone"
                  prepend-icon="mdi-cellphone-android"
                  label="Мобільний"
                  dense readonly
                  color="black">
                </v-text-field>
              </v-col>
              <v-col cols="12" md="7">
                <v-text-field
                  v-model="calcObj.contact_email"
                  prepend-icon="mdi-at"
                  label="Е-mail"
                  dense readonly
                  color="black">
                </v-text-field>
              </v-col>
            </v-row>
            <v-text-field
              v-model="calcObj.service_agreement"
              label="Чи згоден Клієнт на договір Сервісу (якщо НІ, вказувати причину та строк надання остаточної відповіді)"
              dense
              color="black">
            </v-text-field>
            <v-text-field
              v-model="calcObj.fuel_card_agreement"
              label="Чи згоден Клієнт на договір Паливною карти (якщо НІ, вказувати причину та строк надання остаточної відповіді)"
              dense
              :readonly="calcObj.fuel_card_agreement == 'так'"
              color="black">
            </v-text-field>
          </div>
          <div v-if="calcObj.supplier_type && calcObj.supplier_type === 2">
            <v-select
              v-if="legalContactPersons.length > 0 && !currContactPerson"
              @change="assignPerson()"
              :items="legalContactPersons"
              :error-messages="currContactPersonErr"
              item-text="name"
              return-object
              v-model="currContactPerson"
              label="Оберiть контактну особу"
              dense
              color="black"
              item-color="black">
            </v-select>
            <div v-if="currContactPerson">
              <v-text-field
                v-model="calcObj.contact_name"
                label="П.І.Б."
                dense readonly
                color="black">
                <template #append>
                  <v-hover v-slot="{ hover }">
                    <v-btn 
                      @click="deletePerson"
                      icon>
                      <v-tooltip bottom color="#e57373">
                        <template 
                          v-slot:activator="{ on }">
                          <v-icon 
                            v-on="on"
                            :color="hover ? 'grey darken-4' : 'grey darken-1'" 
                            v-text="'mdi-close'">
                          </v-icon>
                        </template>
                        <span>Змiнити контактну особу</span>
                      </v-tooltip>
                    </v-btn>
                  </v-hover>
                </template>
              </v-text-field>
              <v-text-field
                v-model="calcObj.contact_position"
                label="Посада"
                dense readonly
                color="black">
              </v-text-field>
              <v-text-field
                v-model="calcObj.contact_phone"
                prepend-icon="mdi-cellphone-android"
                label="Мобільний"
                dense readonly
                color="black">
              </v-text-field>
              <v-text-field
                v-model="calcObj.contact_email"
                prepend-icon="mdi-at"
                label="Е-mail"
                dense readonly
                color="black">
              </v-text-field>
            </div>
          </div>
        </v-card-text>

        <v-card-title class="custom-title">
          Планові дати реалізації проекту Фронт-менеджером
        </v-card-title>
        <v-card-text class="pt-6">
          <v-row>
            <v-col cols="12" md="6" class="pt-0 pb-0">
              <v-dialog
                v-model="plannedDataToSign" 
                ref="plannedDataToSign"
                width="290px">
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-on="on"
                    @focus="formatDateOnFocus('plannedDataToSign')" 
                    v-model="calcObj.signing_agreement_date"  
                    label="Планована дата підписання договорів"
                    color="black"
                    prepend-icon="mdi-calendar-range"
                    dense>
                  </v-text-field>
                </template>
                <v-date-picker 
                  @change="save"
                  v-model="choosedDate"  
                  color="#e57373" 
                  :min="currentTime" 
                  :max="currentPlusThreeMonth">
                </v-date-picker>
              </v-dialog>
            </v-col>
            <v-col cols="12" md="6" class="pt-0 pb-0">
              <v-dialog
                v-model="plannedDataToAdvancePayment" 
                ref="plannedDataToAdvancePayment"
                width="290px">
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-on="on"
                    @focus="formatDateOnFocus('plannedDataToAdvancePayment')"
                    prepend-icon="mdi-calendar-range"
                    v-model="calcObj.advance_payment_date"
                    label="Планована дата оплати авансу Клієнтом з ДФЛ"
                    dense
                    color="black">
                  </v-text-field>
                </template>
                <v-date-picker 
                  @change="save"
                  v-model="choosedDate"  
                  color="#e57373" 
                  :min="currentTime" 
                  :max="currentPlusThreeMonth">
                </v-date-picker>
              </v-dialog>
            </v-col>
          </v-row>
          <v-text-field
            v-model="calcObj.start_date"
            prepend-icon="mdi-calendar-range"
            label="Планована дата виборки кредиту (оплата залишкової частини вартості ОЛ або 100% оплата постачальнику)"
            dense readonly
            disabled
            color="black">
          </v-text-field>
          <v-row>
            <v-col cols="12" md="6" class="pt-0 pb-0">
              <v-dialog
                v-model="plannedDataToShipment"
                ref="plannedDataToShipment"
                width="290px">
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-on="on"
                    @focus="formatDateOnFocus('plannedDataToShipment')"
                    prepend-icon="mdi-calendar-range"
                    v-model="calcObj.shipment_leasing_object"
                    label="Планована дата відвантаження ОЛ"
                    dense
                    color="black">
                  </v-text-field>
                </template>
                <v-date-picker 
                  @change="save"
                  v-model="choosedDate"  
                  color="#e57373" 
                  :min="currentTime" 
                  :max="currentPlusThreeMonth">
                </v-date-picker>
              </v-dialog>
            </v-col>
          </v-row>
          <v-text-field
            v-model="calcObj.shipment_city"
            prepend-icon="mdi-map-marker"
            label="Місто відвантаження ОЛ"
            dense
            color="black">
          </v-text-field>
          <v-text-field
            v-model="calcObj.finance_monitor"
            label="Чи підпадає Лізингоодержувач під фінансовий моніторинг"
            dense readonly
            color="black">
          </v-text-field>
          <v-text-field
            v-model="calcObj.real_owner"
            label="Реальний власник Лізингоодержувача"
            dense readonly
            color="black">
          </v-text-field>
          <v-text-field
            v-model="calcObj.beneficiary"
            label="Кінцевий бенефіціарний власник"
            dense readonly
            color="black">
          </v-text-field>
          <v-text-field
            v-model="calcObj.front_manager"
            label="Фронт-менеджер"
            dense readonly
            color="black">
          </v-text-field>
          <v-text-field
            v-model="calcObj.middle_manager"
            label="Мідл-менеджер"
            dense readonly
            color="black">
          </v-text-field>
          <v-text-field
            v-model="calcObj.sales_director"
            label="Директор з продажів та маркетингу"
            dense readonly
            color="black">
          </v-text-field>
        </v-card-text>
        <v-card-actions class="justify-center btn-wrapper">
          <v-btn 
            @click="updateProfile()"
            small 
            class="white--text custom" 
            color="grey darken-3"
            :loading="loading">Зберегти</v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import axios from 'axios'
import { validationMixin } from 'vuelidate'
import { required } from 'vuelidate/lib/validators'

export default {
  mixins: [validationMixin],

  name: 'Form',

  data: () => ({
    loading: false,
    plannedDataToSign: false,
    plannedDataToAdvancePayment: false,
    plannedDataToShipment: false,
    choosedDate: null,
    currDateSlctor: null,
    legalContactPersons: [],
    currContactPerson: null,
    overlay: true,
    contactPositionOverlay: false,
    calcObj: {
      /* Main form block */
      project_name: null,
      project_type: null,
      advance: null,
      leasing_term: null,
      amount_of_financing: null,
      leasing_object_name: null,
      quantity: null,
      insurance_program: null,
      franchise: null,
      non_standart_comment: null,
      lead_source: null,
      agent_info: null,
      front_manager_comment: null,

      /* Supliers scheeme */
      supplier_name: null,
      leasing_amount_dkp: null,
      availability_leasing_object: null,
      supplier_prepayment: null,
      preliminary_financing: null,
      gps_tracker: null,

      /* Contact person */
      contact_name: null,
      contact_position: null,
      contact_phone: null,
      contact_email: null,
      service_agreement: null,
      fuel_card_agreement: null,

      /* Front manager plan */
      signing_agreement_date: null,
      advance_payment_date: null,
      start_date: null,
      shipment_leasing_object: null,
      shipment_city: null,
      finance_monitor: null,
      real_owner: null,
      beneficiary: null,
      front_manager: null,
      middle_manager: null,
      sales_director: null,

      /* Other */
      supplier_type: null,
    }
  }),

  validations() {
    return this.validateObj
  },

  computed: {
    validateObj() {
      return {
        currContactPerson: (() => { 
          let supl = this.calcObj.supplier_type
          if(supl === 1 || supl == "1") return true
          else return { required }
        })(),
      }
    },
    currContactPersonErr() {
      const errors = []
			if (!this.$v.currContactPerson.$error) return errors
			!this.$v.currContactPerson.required && errors.push('Оберiть контактну особу')
			return errors
    },
    currentTime() { 
      let currentDate = new Date()
      let month = currentDate.getUTCMonth()
      let day = currentDate.getUTCDate()
      let year = currentDate.getUTCFullYear()

      return new Date(year, month, day + 1).toISOString().substr(0, 10)
    },
    currentPlusThreeMonth() {
      let currentDate = new Date()
      let month = currentDate.getUTCMonth()
      let day = currentDate.getUTCDate()
      let year = currentDate.getUTCFullYear()

      return new Date(year, month + 3, day).toISOString().substr(0, 10)
    },
  },

  methods: {
    getProposal() {
      axios
        .get('/api/getOrCreateProposal')
        .then(res => {
          console.log(res)
          this.overlay = false
          Object.assign(this.calcObj, res.data)
          setTimeout(() => {this.afterGetProposal()}, 0)
        })
        .catch(err => {
          console.log(err)
          this.notify(err.response.status, err.response.data.message && err.response.data.message != '' ? err.response.data.message : err.response.data.exception)
          this.overlay = false
        })
    },
    assignPerson() {
      this.calcObj.contact_email = this.currContactPerson.email
      this.calcObj.contact_name = this.currContactPerson.name
      this.calcObj.contact_position = this.currContactPerson.post
      this.calcObj.contact_phone = this.currContactPerson.phone
    },
    deletePerson() {
      this.currContactPerson = null
      this.calcObj.contact_email = null
      this.calcObj.contact_name = null
      this.calcObj.contact_position = null
      this.calcObj.contact_phone = null
    },
    toLclInt(val) {
      return parseInt(this.calcObj.amount_of_financing.replace(/[^\d]/g, ''))
        .toLocaleString('ru')
    },
    afterGetProposal() {
      this.calcObj.amount_of_financing = this.toLclInt(this.calcObj.amount_of_financing)
      this.calcObj.leasing_amount_dkp = this.toLclInt(this.calcObj.leasing_amount_dkp)
    },
    formatDateOnFocus(selector) {
      this.currDateSlctor = selector
      let date
      switch(selector) {
        case 'plannedDataToSign': date = this.calcObj.signing_agreement_date;
          break;
        case 'plannedDataToAdvancePayment': date = this.calcObj.advance_payment_date;
          break;
        case 'plannedDataToShipment': date = this.calcObj.shipment_leasing_object;
          break;
      }

      if(date) {
        let [day, month, year] = date.split('.')
        this.choosedDate = `${year}-${month}-${day}`
      }
    },
    getCompanyUsers() {
      this.contactPositionOverlay = true
      console.log(this.contactPositionOverlay)
      axios
        .get(`/api/getCompanyUsers/${this.calcObj.deal_id}`)
        .then(res => {
          console.log(res)
          this.legalContactPersons = res.data
          this.contactPositionOverlay = false
          console.log(this.contactPositionOverlay)
        })
        .catch(err => {
          console.log(err)
          this.contactPositionOverlay = false
          this.notify(err.response.status, err.response.data.message && err.response.data.message != '' ? err.response.data.message : err.response.data.exception)
        })
    },
    offerUpdate() {
      this.loading = true
      console.log(this.objectToUpdate())
      axios
        .post('/offer/update', this.objectToUpdate())
        .then(() => {
          this.getProposal()
          this.notify('Успiшно оновлено')
          this.loading = false
        })
        .catch(err => {
          console.log({ERROR: err})
          this.notify(err.response.status, err.response.data.message && err.response.data.message != '' ? err.response.data.message : err.response.data.exception)
          this.loading = false
        })
    },
    updateProfile() {
      !this.$v.$invalid
        ? this.offerUpdate()
        : this.highlightErrors()
    },
    highlightErrors() {
      setTimeout(() => {this.notify('Помилка', 'Оберiть контактну особу')}, 330)
      this.$v.$anyError
      this.$v.$touch()
      contactPerson.scrollIntoView({behavior: "smooth"})
    },
    getCsrf() {
			return document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    objectToUpdate() {
      let obj = {
        non_standart_comment: this.calcObj.non_standart_comment,
        front_manager_comment: this.calcObj.front_manager_comment,
        availability_leasing_object: this.calcObj.availability_leasing_object,
        supplier_prepayment: this.calcObj.supplier_prepayment,
        service_agreement: this.calcObj.service_agreement,
        fuel_card_agreement: this.calcObj.fuel_card_agreement,
        signing_agreement_date: this.calcObj.signing_agreement_date,
        advance_payment_date: this.calcObj.advance_payment_date,
        shipment_leasing_object: this.calcObj.shipment_leasing_object,
        shipment_city: this.calcObj.shipment_city,
        offer_id: this.calcObj.id,
        contact_name: this.calcObj.contact_name,
        contact_position: this.calcObj.contact_position,
        contact_phone: this.calcObj.contact_phone,
        contact_email: this.calcObj.contact_email,

        _token: this.getCsrf()
      }
      
      Object.keys(obj).forEach(key => {
        if(!obj[key] || obj[key] === '') delete obj[key]
      })

      let supl = this.calcObj.supplier_type
      if(supl === 1 || supl === '1') {
        delete this.calcObj.contact_name
        delete this.calcObj.contact_position
        delete this.calcObj.contact_phone
        delete this.calcObj.contact_email
      }

      console.log({OBJECT: obj})

      return obj
    },
    save(date) {
      console.log(date)
      switch(this.currDateSlctor) {
        case 'plannedDataToSign': this.$refs.plannedDataToSign.save(date); 
          break;
        case 'plannedDataToAdvancePayment': this.$refs.plannedDataToAdvancePayment.save(date);
          break;
        case 'plannedDataToShipment': this.$refs.plannedDataToShipment.save(date)
      }
    },
    notify(title, text) {
      this.$snotify.simple(text, title, {
        timeout: 2000,
        showProgressBar: false,
        closeOnClick: true,
        pauseOnHover: true
      })
    },
  },

  watch: {
    'calcObj.supplier_type': function (val) {
      if(val === 2) {
        this.getCompanyUsers()
      }
    },
    choosedDate(val) {
      const [year, month, day] = val.split('-')

      switch(this.currDateSlctor) {
        case 'plannedDataToSign': this.calcObj.signing_agreement_date = `${day}.${month}.${year}`
          break;
        case 'plannedDataToAdvancePayment': this.calcObj.advance_payment_date = `${day}.${month}.${year}`
          break;
        case 'plannedDataToShipment': this.calcObj.shipment_leasing_object = `${day}.${month}.${year}`
      }
    },
  },

  mounted() {
    console.log(this.$v)
    this.getProposal()
  }
}
</script>

<style>
@import "~vue-snotify/styles/material.css";

.custom-title {
  background: #e57373;
  padding: 4px 16px!important; 
  font-size: 1.12rem!important;
  color: white;
  border-radius: 4px 0 0 0;
}
.btn-wrapper > button.custom {
  padding: 0 15px!important;
  letter-spacing: 0.05rem!important;
}
.snotifyToast {
  background: #333c41e8!important;
  text-overflow: ellipsis!important;
  overflow: hidden!important;
}
.snotifyToast__title, .snotifyToast__body {
  color:  white!important;
} 
.snotifyToast__title {
  font-size: 1.37rem!important;
}
.snotifyToast__body {
  font-size: 0.95rem!important;
  text-overflow: ellipsis!important;
  overflow: hidden!important;
}
</style>