import { isBoolean } from 'lodash';
import {register} from './rules'


export const rs = (title,obj)=>{
    let result= [];

    // jodi obj object na hoye boolyen hoy tahole buje nite hobe required call kora hoice
    if(isBoolean(obj)){
        if(obj){
            result.push(( Object.create(register.required)).valid(title))
        }
        return result;
    }

    try {
      
        for (const key in obj) {
            let prop = key
            if(!Object.prototype.hasOwnProperty.call(register, prop)) throw `prop ${prop} not are Register Validating Functions`;
            let arg = obj[prop]
            let isBool = isBoolean(arg);
            let x = Object.create(register[prop]);
         
            if(prop =='required'){
            if(arg){
                result.push(x.valid(title))
            }
            }else if(isBool && arg){
                
              result.push(x.valid(title))
            }else{
                result.push(x.valid(title,arg))
            }
        }

       
        
    } catch (error) {
        console.error(error)
    }

  
 //  console.log(result)

    return result;
}