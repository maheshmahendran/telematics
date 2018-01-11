export class Device {
    constructor(
        public device_id: string,
        public device_label: string,
        public last_reported_time: string,
        public status?: string,
        public colorCode?: string,
        public formatedLRT? : Date
    ) {
        this.status = status || 'OFFLINE';
        this.colorCode = (this.status == 'OK')? 'green' : 'red';
        this.formatedLRT = new Date(this.last_reported_time);
    }
}