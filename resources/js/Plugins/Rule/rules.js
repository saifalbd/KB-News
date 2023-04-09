import { isBoolean, isPlainObject, isUndefined, keys } from "lodash";


const r = (v)=>{
  typeof v;
  if(typeof v =='number'){
    return true;
  }else if(v==null){
    return false;
  }else if(v==''){
    return false;
  }else if(isUndefined(v)){
    return false;
  }else if(isBoolean(v)){
    return true; 
  }else if(isPlainObject(v)){
    return !!keys(v).length
  }else if(Array.isArray(v)){
    return !!v.length
  }
  return !!v;
}

const required = {
  message: "",
  validate:r,
  valid(name) {
    this.message = `${name} should be must`;
    return (v) => this.validate(v) || this.message;
  },
};

const email = {
  message: "",
  validate(v) {
    if(!r(v)) return true;
    let filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return filter.test(v)

  },
  valid(name) {
    this.message = `${name} Not Valid Email`;
    return v=> this.validate(v) || this.message;
  },
}

const minLength = {
    message: "",
    validate(v,length) {
      return String(v).length>=length;
    },
    valid(name,length) {
      this.message = `The ${name} must be at least ${length} characters`;
      return (v) => this.validate(v,length) || this.message;
    },
  };
  const maxLength = {
    message: "",
    validate(v,length) {
      return String(v).length<=length;
    },
    valid(name,length) {
      this.message = `The ${name} may not be greater than ${length} characters`;
      return (v) => this.validate(v,length) || this.message;
    },
  };


  const numeric = {
    message: "value should be Numeric",
    validate(v) {
      return !isNaN(v);
    },
    valid(name) {
      return  (v) => this.validate(v) || this.message;
    },
  }








export const register = {
  required,
  numeric,
  email,
  minLength,
  maxLength
};
