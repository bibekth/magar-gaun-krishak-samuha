package com.techenfield.mgks.models;

public class UserModel {
    protected String status;
    protected Body body;

    public UserModel() {
    }

    public UserModel(String status, Body body) {
        this.status = status;
        this.body = body;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public Body getBody() {
        return body;
    }

    public void setBody(Body body) {
        this.body = body;
    }

    public static class Body{
        protected String token, role;
        protected User user;

        public Body() {
        }

        public Body(String token, String role, User user) {
            this.token = token;
            this.role = role;
            this.user = user;
        }

        public String getToken() {
            return token;
        }

        public void setToken(String token) {
            this.token = token;
        }

        public String getRole() {
            return role;
        }

        public void setRole(String role) {
            this.role = role;
        }

        public User getUser() {
            return user;
        }

        public void setUser(User user) {
            this.user = user;
        }

        public static class User{
            protected String id, member_id, name, phone_number, email, role_id, device_id, fcm_id, password;

            public User() {
            }

            public User(String id, String member_id, String name, String phone_number, String email, String role_id) {
                this.id = id;
                this.member_id = member_id;
                this.name = name;
                this.phone_number = phone_number;
                this.email = email;
                this.role_id = role_id;
            }

            public User(String id, String member_id, String name, String phone_number, String email, String role_id, String device_id, String fcm_id) {
                this.id = id;
                this.member_id = member_id;
                this.name = name;
                this.phone_number = phone_number;
                this.email = email;
                this.role_id = role_id;
                this.device_id = device_id;
                this.fcm_id = fcm_id;
            }

            public User(String phone_number, String email, String device_id, String fcm_id, String password) {
                this.phone_number = phone_number;
                this.email = email;
                this.device_id = device_id;
                this.fcm_id = fcm_id;
                this.password = password;
            }

            public String getId() {
                return id;
            }

            public void setId(String id) {
                this.id = id;
            }

            public String getMember_id() {
                return member_id;
            }

            public void setMember_id(String member_id) {
                this.member_id = member_id;
            }

            public String getName() {
                return name;
            }

            public void setName(String name) {
                this.name = name;
            }

            public String getPhone_number() {
                return phone_number;
            }

            public void setPhone_number(String phone_number) {
                this.phone_number = phone_number;
            }

            public String getEmail() {
                return email;
            }

            public void setEmail(String email) {
                this.email = email;
            }

            public String getRole_id() {
                return role_id;
            }

            public void setRole_id(String role_id) {
                this.role_id = role_id;
            }

            public String getDevice_id() {
                return device_id;
            }

            public void setDevice_id(String device_id) {
                this.device_id = device_id;
            }

            public String getFcm_id() {
                return fcm_id;
            }

            public void setFcm_id(String fcm_id) {
                this.fcm_id = fcm_id;
            }
        }
    }
}
