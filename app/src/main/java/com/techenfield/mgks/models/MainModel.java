package com.techenfield.mgks.models;

import com.google.gson.annotations.SerializedName;

public class MainModel {
    public String status;
    public Body body;

    public MainModel() {
    }

    public MainModel(String status, Body body) {
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
        public String userName, totalSavings, totalDebtCollected, fine, payableInterest, payableSaving, monthsToPay, remainingDebt;
        public LastDownPayment lastDownPayment;
        public Body() {
        }

        public Body(String userName, String totalSavings, String totalDebtCollected, String fine, String payableInterest, String payableSaving, String monthsToPay, String remainingDebt, LastDownPayment lastDownPayment) {
            this.userName = userName;
            this.totalSavings = totalSavings;
            this.totalDebtCollected = totalDebtCollected;
            this.fine = fine;
            this.payableInterest = payableInterest;
            this.payableSaving = payableSaving;
            this.monthsToPay = monthsToPay;
            this.remainingDebt = remainingDebt;
            this.lastDownPayment = lastDownPayment;
        }

        public String getRemainingDebt() {
            return remainingDebt;
        }

        public void setRemainingDebt(String remainingDebt) {
            this.remainingDebt = remainingDebt;
        }

        public LastDownPayment getLastDownPayment() {
            return lastDownPayment;
        }

        public void setLastDownPayment(LastDownPayment lastDownPayment) {
            this.lastDownPayment = lastDownPayment;
        }

        public String getUserName() {
            return userName;
        }

        public void setUserName(String userName) {
            this.userName = userName;
        }

        public String getTotalSavings() {
            return totalSavings;
        }

        public void setTotalSavings(String totalSavings) {
            this.totalSavings = totalSavings;
        }

        public String getTotalDebtCollected() {
            return totalDebtCollected;
        }

        public void setTotalDebtCollected(String totalDebtCollected) {
            this.totalDebtCollected = totalDebtCollected;
        }

        public String getFine() {
            return fine;
        }

        public void setFine(String fine) {
            this.fine = fine;
        }

        public String getPayableInterest() {
            return payableInterest;
        }

        public void setPayableInterest(String payableInterest) {
            this.payableInterest = payableInterest;
        }

        public String getPayableSaving() {
            return payableSaving;
        }

        public void setPayableSaving(String payableSaving) {
            this.payableSaving = payableSaving;
        }

        public String getMonthsToPay() {
            return monthsToPay;
        }

        public void setMonthsToPay(String monthsToPay) {
            this.monthsToPay = monthsToPay;
        }

        public static class LastDownPayment{
            String year, month, down_payment_amount;

            public LastDownPayment() {
            }

            public LastDownPayment(String year, String month, String down_payment_amount) {
                this.year = year;
                this.month = month;
                this.down_payment_amount = down_payment_amount;
            }

            public String getYear() {
                return year;
            }

            public void setYear(String year) {
                this.year = year;
            }

            public String getMonth() {
                return month;
            }

            public void setMonth(String month) {
                this.month = month;
            }

            public String getDown_payment_amount() {
                return down_payment_amount;
            }

            public void setDown_payment_amount(String down_payment_amount) {
                this.down_payment_amount = down_payment_amount;
            }
        }
    }
}
