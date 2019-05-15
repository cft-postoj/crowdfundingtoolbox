export class Targeting {
    signed_status = {
        signed : {
            active: true
        },
        not_signed : {
            active: false
        }
    };
   support = {
       one_time : {
           active: true,
           older_than: {
               active: true,
               value: 30
           },
           not_older_than: {
               active: false,
               value: 60
           },
           min: {
               active: false,
               value: 50
           },
           max: {
               active: false,
               value: 100
           }
       },
       monthly : {
           active: false,
           older_than: {
               active: true,
               value: 50
           },
           not_older_than: {
               active: false,
               value: 90
           },
           min: {
               active: false,
               value: 5
           },
           max: {
               active: false,
               value: 15
           }
       },
       not_supporter : {
           active: false
       }
   };
    read_articles = {
        today: {
            active: false,
            min: 0,
            max: 5
        },
        week: {
            active: false,
            min: 10,
            max: 25
        },
        month: {
            active: true,
            min: 20,
            max: 0
        }
    }
    registration: any  = {
        before: {
            active: false,
            date:  { year: new Date().getFullYear(), month: new Date().getMonth()+1, day: new Date().getDate()},
        },
        after: {
            active: false,
            date: { year: new Date().getFullYear(), month: new Date().getMonth()+1, day: new Date().getDate()}
        }
    }
    url = {
        specific: false,
        list: [
            {id:0, path:'https://www.postoj.sk'},
            {id:0, path:'https://www.postoj.sk/politika'}
            ]
    }
}