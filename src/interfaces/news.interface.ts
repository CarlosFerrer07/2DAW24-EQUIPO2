export interface DataNews {
    id:          number;
    title:       string;
    start_date:  StartDate;
    description: string;
    image:       string;
    source:      string;
}

export interface StartDate {
    date:          Date;
    timezone_type: number;
    timezone:      string;
}