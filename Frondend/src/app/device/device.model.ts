export class Device {
    constructor(
        public deviceId: string,
        public deviceLabel: string,
        public lastReportedTime: string,
        public status?: string,
        public colorCode?: string,
        public formatedLRT? : Date
    ) {
        this.status = status || 'OFFLINE';
        this.colorCode = (this.status == 'OK')? 'green' : 'red';
        this.formatedLRT = new Date(this.lastReportedTime);
    }
}